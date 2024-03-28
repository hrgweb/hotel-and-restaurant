import { defineStore } from 'pinia'
import type { Role } from '../types'
import { nextTick } from 'vue'

export const useRoleStore = defineStore('role', {
  state: () => ({
    resource: 'user-roles',
    data: [] as Role[],
    form: {
      role: '',
    } as Role,
    editForm: {
      role: '',
    } as Role,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedRole: null as Role | null,
    index: 0,
    searchResult: [] as Role[],
    isSearch: false,
    query: '',
    isBulk: false,
  }),

  actions: {
    save() {
      this.errorMsg = ''

      axios
        .post(`/${this.resource}`, this.form)
        .then(({ data }) => {
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    edit(table: Role, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedRole = table
      this.editForm = table
      this.index = index
    },

    update() {
      this.errorMsg = ''

      axios
        .patch(`/${this.resource}/${this.selectedRole?.id}`, this.editForm)
        .then(({ data }) => {
          this.data[this.index].role = data?.role
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    reset() {
      this.form.role = ''
    },

    async new() {
      this.showForm = !this.showForm
      this.isEdit = false
      this.reset()
      this.errorMsg = ''
      await nextTick()
      document.getElementById('role')?.focus()
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

    askRemove(table: Role, index: number) {
      this.selectedRole = table
      this.index = index
    },

    remove() {
      return axios.delete(`/${this.resource}/${this.selectedRole?.id}`)
    },
  },
})
