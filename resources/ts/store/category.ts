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
    selectCategory: null as Category,
  }),

  actions: {
    save(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('name', this.form.name)
      formData.append('desc', this.form.desc)
      formData.append('thumbnail', this.form.desc)

      if (hasThumbnail) {
        formData.append('file', this.form.thumbnail)
      }

      axios
        .post('/categories', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(() => {
          this.showForm = false
          this.reset()
        })
        .catch((error) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
    },

    edit(category: Category) {
      this.showForm = true
      this.isEdit = true
      this.selectCategory = category
      this.editForm = category
    },

    update(hasThumbnail: boolean) {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('_method', 'PATCH')
      formData.append('name', this.editForm.name)
      formData.append('desc', this.editForm.desc)
      formData.append('thumbnail', this.form.desc)

      if (hasThumbnail) {
        formData.append('file', this.editForm.thumbnail)
      }

      axios
        .post(`/categories/${this.selectCategory?.id}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((response) => {
          this.reset()
        })
        .catch((error) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
        .finally(() => (this.showForm = false))
    },

    reset() {
      this.form.name = ''
      this.form.desc = ''
      this.form.thumbnail = null
    },

    close() {
      this.isEdit = false
    },
  },
})
