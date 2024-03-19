import { defineStore } from 'pinia'
import type { Staff } from '@/domain/staff/types/index'

export const useStaffStore = defineStore('staff', {
  state: () => ({
    resource: 'staffs',
    data: [] as Staff[],
    form: {
      name: '',
      desc: '',
      file: null as Blob | null,
      thumbnail: '',
    } as Staff,
    editForm: {
      name: '',
      desc: '',
      file: null as Blob | null,
      thumbnail: '',
    } as Staff,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedStaff: null as Staff,
    index: 0,
    searchResult: [] as Staff[],
    isSearch: false,
    query: '',
  }),

  actions: {
    save() {
      this.errorMsg = ''

      axios
        .post(`/${this.resource}`, this.form)
        .then(({ data }: Staff) => {
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    edit(category: Staff, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedStaff = category
      this.editForm = category
      this.index = index
    },

    update() {
      this.errorMsg = ''

      axios
        .patch(`/${this.resource}/${this.selectedStaff?.id}`, this.editForm)
        .then(({ data }: Staff) => {
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
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
          data.role?.toLowerCase().indexOf(this.query.toLowerCase()) !== -1
      )
    },

    clearSearch() {
      this.isSearch = false
      this.query = ''
      document.getElementById('query')?.focus()
    },

    askRemove(category: Staff, index: number) {
      this.selectedStaff = category
      this.index = index
    },

    remove() {
      return axios.delete(`/${this.resource}/${this.selectedStaff?.id}`)
    },
  },
})
