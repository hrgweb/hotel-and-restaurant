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
      file: null as Blob | null,
      thumbnail: '',
      price: 0,
    } as Product,
    editForm: {
      category_id: 0,
      barcode: '',
      name: '',
      desc: '',
      file: null as Blob | null,
      thumbnail: '',
      price: 0,
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
  }),

  actions: {
    save(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('name', this.form.name)
      formData.append('desc', this.form.desc)
      formData.append('thumbnail', '')

      if (hasThumbnail) {
        formData.append('image', this.form.image)
      }

      axios
        .post('/categories', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Product) => {
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
    },

    edit(category: Product, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedCategory = category
      this.editForm = category
      this.index = index
    },

    update(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('_method', 'PATCH')
      formData.append('name', this.editForm.name)
      formData.append('desc', this.editForm.desc)
      formData.append('thumbnail', '')

      if (hasThumbnail) {
        formData.append('image', this.editForm.image)
      }

      axios
        .post(`/categories/${this.selectedCategory?.id}`, formData, {
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
