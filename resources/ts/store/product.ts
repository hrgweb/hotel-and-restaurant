import { defineStore } from 'pinia'
import type { Product } from '@/types/product'
import type { Category } from '@/types/category'

export const useProductStore = defineStore('product', {
  state: () => ({
    data: [] as Product[],
    form: {
      category_id: 0,
      barcode: '',
      name: '',
      desc: '',
      image: null as Blob | null,
      thumbnail: '',
      price: 0,
      available: true,
    } as Product,
    editForm: {
      category_id: 0,
      barcode: '',
      name: '',
      desc: '',
      image: null as Blob | null,
      thumbnail: '',
      price: 0,
      available: true,
    } as Product,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedCategory: null as Category,
    index: 0,
    searchResult: [] as Product[] | null,
    isSearch: false,
    query: '',
    categories: [] as Category[] | null,
    selectedProduct: null as Product,
  }),

  actions: {
    save(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('barcode', this.form.barcode)

      if (this.selectedCategory?.id) {
        formData.append('category_id', this.selectedCategory?.id)
      }

      formData.append('name', this.form.name)
      formData.append('desc', this.form.desc)
      formData.append('thumbnail', '')
      formData.append('price', this.form.price)
      formData.append('available', this.form.available)

      if (hasThumbnail) {
        formData.append('image', this.form.image)
      }

      axios
        .post('/products', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Product) => {
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    edit(product: Product, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedProduct = product
      this.selectedCategory = product?.category
      this.editForm = product
      this.editForm.available = product?.available ? true : false
      this.index = index
    },

    update(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('_method', 'PATCH')
      formData.append('barcode', this.editForm.barcode)

      if (this.selectedCategory?.id) {
        formData.append('category_id', this.selectedCategory?.id)
      }

      formData.append('name', this.editForm.name)
      formData.append('desc', this.editForm.desc)
      formData.append('thumbnail', '')
      formData.append('price', this.editForm.price)
      formData.append('available', this.editForm.available)

      if (hasThumbnail) {
        formData.append('image', this.editForm.image)
      }

      axios
        .post(`/products/${this.selectedProduct?.id}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Product) => {
          if (data?.thumbnail) {
            this.data[this.index].thumbnail = data?.thumbnail // update thumbnail
          }
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
    },

    reset() {
      this.form.name = ''
      this.form.desc = ''
      this.form.image = null
      this.form.thumbnail = ''
    },

    new() {
      this.showForm = !this.showForm
      this.isEdit = false
      this.reset()
      this.errorMsg = ''
    },

    close() {
      this.isEdit = false
      this.showForm = false
    },

    search() {
      if (!this.query) return

      this.isSearch = true
      this.searchResult = this.data.filter(
        (data) =>
          data.name?.toLowerCase().indexOf(this.query.toLowerCase()) !== -1
      )
    },

    clearSearch() {
      this.isSearch = false
      this.query = ''
      document.getElementById('query')?.focus()
    },

    askRemove(category: Product, index: number) {
      this.selectedCategory = category
      this.index = index
    },

    remove() {
      return axios.delete(`/categories/${this.selectedCategory?.id}`)
    },
  },
})
