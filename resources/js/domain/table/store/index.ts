import { defineStore } from 'pinia'
import type { Table } from '../types'

export const useTableStore = defineStore('table', {
  state: () => ({
    resource: 'tables',
    data: [] as Table[],
    form: {
      prefix: 'Table',
      name: '',
      bulkOfTable: 0,
    } as Table,
    editForm: {
      prefix: 'Table',
      name: '',
      bulkOfTable: 0,
    } as Table,
    isEdit: false,
    errorMsg: '',
    showForm: false,
    selectedTable: null as Table | null,
    index: 0,
    searchResult: [] as Table[],
    isSearch: false,
    query: '',
    isBulk: false,
  }),

  actions: {
    save() {
      this.errorMsg = ''
      this.form['isBulk'] = this.isBulk

      axios
        .post(`/${this.resource}`, this.form)
        .then(({ data }) => {
          // If result is collection, its bulked
          if (data && data.length && Array.isArray(data)) {
            data.forEach((item: Table | null, index: number) => {
              let newItem = item as any
              newItem['table_name'] = `${item?.prefix} ${item?.name}`
              this.data.push(newItem)
            })
          } else {
            data['table_name'] = `${data?.prefix} ${data?.name}`
            this.data.push(data)
          }

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
      this.form['isBulk'] = this.isBulk

      axios
        .patch(`/${this.resource}/${this.selectedTable?.id}`, this.editForm)
        .then(({ data }) => {
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
      this.errorMsg = ''
      this.isBulk = false
      this.form.prefix = 'Table'
      this.form.bulkOfTable = 0
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
      this.showForm = !this.showForm
      this.isEdit = false
      this.reset()
      this.form.prefix = 'Table'
      this.errorMsg = ''
      this.isBulk = true
    },
  },
})
