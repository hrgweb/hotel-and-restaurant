import { defineStore } from 'pinia'
import type { Product } from '@/types/product'
import type { Category } from '@/types/category'

type Form = {
  category_id?: number
  barcode: string
  name: string
  desc: string
  image: any
  thumbnail: string
  price: number
  available: boolean
  [key: string]: any
}

export const useProductStore = defineStore('product', {
  state: () => ({
    resource: 'products',
    data: [] as any[],
    form: {
      category_id: 0,
      barcode: '',
      name: '',
      desc: '',
      image: null,
      thumbnail: '',
      price: 0,
      available: true,
    } as Form,
    editForm: {
      category_id: 0,
      barcode: '',
      name: '',
      desc: '',
      image: null,
      thumbnail: '',
      price: 0,
      available: true,
    } as Form,
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
    loading: false,
  }),

  actions: {
    save(hasThumbnail: boolean) {
      this.loading = true
      this.errorMsg = ''

      const formData = this.formData(this.form, hasThumbnail)

      axios
        .post(`/${this.resource}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Product) => {
          data['category'] = this.selectedCategory
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
        .finally(() => {
          this.loading = false
        })
    },

    formData(form: Form, hasThumbnail: boolean) {
      let formData = new FormData()

      // Add method for update
      if (this.isEdit) {
        formData.append('_method', 'PATCH')
      }

      for (const prop in form) {
        if (prop === 'image') {
          if (hasThumbnail) {
            formData.append(prop, form[prop])
          }
          continue
        }

        if (prop === 'category_id') {
          if (this.selectedCategory?.id) {
            formData.append(prop, this.selectedCategory?.id)
          }
          continue
        }

        formData.append(prop, form[prop])
      }

      return formData
    },

    edit(product: Product, index: number) {
      this.reset()
      this.showForm = true
      this.isEdit = true
      this.selectedProduct = product
      this.selectedCategory = product?.category
      this.editForm = product
      this.editForm.available = product?.available ? true : false
      this.index = index
    },

    update(hasThumbnail: boolean) {
      this.loading = true
      this.errorMsg = ''

      const formData = this.formData(this.editForm, hasThumbnail)

      axios
        .post(`/${this.resource}/${this.selectedProduct?.id}`, formData, {
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
        .finally(() => {
          this.loading = false
        })
    },

    reset() {
      this.form.category_id = 0
      this.form.barcode = ''
      this.form.name = ''
      this.form.desc = ''
      this.form.image = null
      this.form.thumbnail = ''
      this.form.price = 0
      this.form.available = true
      this.selectedCategory = null
    },

    new() {
      this.reset()
      this.showForm = !this.showForm
      this.isEdit = false
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
      return axios.delete(`/${this.resource}/${this.selectedCategory?.id}`)
    },
  },
})
