import { defineStore } from 'pinia'
import type { Category } from '@/types/category.ts'

export const useCategoryStore = defineStore('category', {
  state: () => ({
    data: [] as Category[],
    form: {
      name: '',
      desc: '',
      file: null as Blob | null,
      thumbnail: '',
    } as Category,
    editForm: {
      name: '',
      desc: '',
      file: null as Blob | null,
      thumbnail: '',
    } as Category,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedCategory: null as Category,
    index: 0,
    searchResult: [] as Category[],
    isSearch: false,
    query: '',
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
        .then(({ data }: Category) => {
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
    },

    edit(category: Category, index: number) {
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
        .then(({ data }: Category) => {
          if (data?.thumbnail) {
            this.data[this.index].thumbnail = data?.thumbnail // update thumbnail
          }
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
        .finally(() => (this.showForm = false))
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

    askRemove(category: Category, index: number) {
      this.selectedCategory = category
      this.index = index
    },

    remove() {
      return axios.delete(`/categories/${this.selectedCategory?.id}`)
    },
  },
})
