import { defineStore } from 'pinia'

// @ts-ignore
import type { Category } from '@/types/category.ts'

export const useCategoryStore = defineStore('category', {
  state: () => ({
    data: [] as Category[],
    form: {
      name: '',
      desc: '',
      thumbnail: null,
    } as Category,
    editForm: {
      name: '',
      desc: '',
      thumbnail: null,
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

      if (hasThumbnail) {
        formData.append('thumbnail', this.form.thumbnail)
      }

      axios
        .post('/categories', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(() => this.reset())
        .catch((error) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
        .finally(() => (this.showForm = false))
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

      if (hasThumbnail) {
        formData.append('thumbnail', this.editForm.thumbnail)
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
