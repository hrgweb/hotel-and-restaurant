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
    errorMsg: '',
    showForm: false,
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
        .then((response) => {
          this.form.name = ''
          this.form.desc = ''
          this.form.thumbnail = null
          this.showForm = false
        })
        .catch((error) => {
          this.errorMsg = error?.response?.data
          console.error(error) // Handle error
        })
    },
  },
})
