import { defineStore } from 'pinia'
import type { Staff, User } from '@/domain/staff/types'
import type { Role } from '@/domain/role/types'
import dayjs from 'dayjs'

type Form = {
  role_id: number | null
  user_id: number | null
  first_name: string
  last_name: string
  email: string
  username: string
  gender: string
  dob: Date
}

export const useStaffStore = defineStore('staff', {
  state: () => ({
    resource: 'staffs',
    data: [] as Staff[],
    form: {
      role_id: null,
      user_id: null,
      first_name: '',
      last_name: '',
      email: '',
      username: '',
      gender: '',
      dob: new Date(),
    } as Form,
    editForm: {
      role_id: null,
      user_id: null,
      first_name: '',
      last_name: '',
      email: '',
      username: '',
      gender: '',
      dob: new Date(),
    } as Form,
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
    result: null as Staff,
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

    edit(staff: Staff, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedStaff = staff
      this.index = index
      this.editValues(staff)
    },

    editValues(data: any) {
      this.selectedRole = data.user_role
      this.editForm.role_id = this.selectedRole?.id
      this.editForm.user_id = data?.user?.id
      this.editForm.first_name = data?.user?.first_name
      this.editForm.last_name = data?.user?.last_name
      this.editForm.email = data?.user?.email
      this.editForm.username = data?.user?.username
      this.editForm.gender = data?.user?.gender
      this.editForm.dob = dayjs(data?.user?.dob).format('MM-DD-YYYY')
    },

    update() {
      this.errorMsg = ''
      this.editForm.role_id = this.selectedRole?.id

      axios
        .patch(`/${this.resource}/${this.selectedStaff?.id}`, this.editForm)
        .then(({ data }) => {
          this.updatedValues(data)
          this.showForm = false
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    updatedValues(data: Form) {
      const user = {
        id: data.user_id,
        first_name: data.first_name,
        last_name: data.last_name,
        name: `${data.first_name} ${data.last_name}`,
        email: data.email,
        username: data.username,
        gender: data.gender,
        dob: dayjs(data.dob).format('MM-DD-YYYY'),
      }
      this.data[this.index].user = user
      this.data[this.index].user_role = this.selectedRole
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
      this.reset()
      this.showForm = !this.showForm
      this.isEdit = false
      this.errorMsg = ''
      this.form.gender = 'male'
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
          data?.user.name?.toLowerCase().indexOf(this.query.toLowerCase()) !==
          -1
      )
    },

    clearSearch() {
      this.isSearch = false
      this.query = ''
      document.getElementById('query')?.focus()
    },

    askRemove(staff: Staff, index: number) {
      this.selectedStaff = staff
      this.index = index
    },

    remove() {
      return axios.delete(`/${this.resource}/${this.selectedStaff?.user?.id}`)
    },
  },
})
