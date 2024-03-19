import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types/index'

export const useTableStore = defineStore('table', {
  state: () => ({
    resource: 'tables',
    data: [] as Table[],
    form: {
      name: '',
      prefix: 'Table',
    } as Table,
    editForm: {
      name: '',
      prefix: 'Table',
    } as Table,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedTable: null as Table,
    index: 0,
    searchResult: [] as Table[],
    isSearch: false,
    query: '',
    showFormBulk: false,
    isEditBulk: false,
    closeBulk: false,
  }),

  actions: {
    save() {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('name', this.form.name)
      formData.append('prefix', this.form.prefix)

      axios
        .post(`/${this.resource}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Table) => {
          data['table_name'] = `${data?.prefix} ${data?.name}`
          this.data.push(data)
          this.showForm = false
          this.reset()
        })
        .catch((error: any) => {
          this.errorMsg = error?.response?.data?.message
          console.error(error) // Handle error
        })
    },

    edit(table: Table, index: number) {
      this.showForm = true
      this.isEdit = true
      this.selectedTable = table
      this.editForm = table
      this.index = index
    },

    update() {
      this.errorMsg = ''

      let formData = new FormData()
      formData.append('_method', 'PATCH')
      formData.append('name', this.editForm.name)
      formData.append('prefix', this.editForm.prefix)

      axios
        .post(`/${this.resource}/${this.selectedTable?.id}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then(({ data }: Table) => {
          this.data[this.index].prefix = data?.prefix
          this.data[this.index].name = data?.name
          this.data[this.index].table_name = `${data?.prefix} ${data?.name}`
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
      this.form.prefix = ''
    },

    new() {
      this.showForm = !this.showForm
      this.isEdit = false
      this.reset()
      this.form.prefix = 'Table'
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
          data.table_name?.toLowerCase().indexOf(this.query.toLowerCase()) !==
          -1
      )
    },

    clearSearch() {
      this.isSearch = false
      this.query = ''
      document.getElementById('query')?.focus()
    },

    askRemove(table: Table, index: number) {
      this.selectedTable = table
      this.index = index
    },

    remove() {
      return axios.delete(`/${this.resource}/${this.selectedTable?.id}`)
    },

    createBulk() {
      this.showFormBulk = !this.showFormBulk
      this.isEditBulk = false
      this.reset()
      this.errorMsg = ''
    },

    closeBulk() {
      this.isEditBulk = false
      this.showFormBulk = false
    },
  },
})
