import { defineStore } from 'pinia'
import type { Staff } from '@/domain/staff/types'
import type { Role } from '@/domain/role/types'

export const useStaffStore = defineStore('staff', {
  state: () => ({
    resource: 'staffs',
    data: [] as Staff[],
    form: {
      role_id: null,
      first_name: '',
      last_name: '',
      email: '',
      username: '',
      gender: '',
      dob: new Date(),
    } as Staff,
    editForm: {
      role_id: null,
      last_name: '',
      email: '',
      username: '',
      gender: '',
      dob: new Date(),
      first_name: '',
    } as Staff,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedStaff: null as Staff,
    index: 0,
    searchResult: [] as Staff[],
    isSearch: false,
    query: '',
    roles: [] as Role[],
    selectedRole: null as Role | null,
  }),

  actions: {
    save() {
      this.errorMsg = ''
      this.form['role_id'] = this.selectedRole?.id

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
      this.form.role_id = null
      this.form.first_name = ''
      this.form.last_name = ''
      this.form.email = ''
      this.form.username = ''
      this.form.gender = ''
      this.form.dob = new Date()
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
          data.first_name?.toLowerCase().indexOf(this.query.toLowerCase()) !==
          -1
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
