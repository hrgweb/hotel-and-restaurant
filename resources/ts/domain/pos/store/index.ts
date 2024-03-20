import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'
import type { Category } from '@/domain/category/types'

export const usePosStore = defineStore('pos', {
  state: () => ({
    resource: 'pos',
    tables: [] as Table[],
    categories: [] as Category[],
    showOrder: false,
    selectedTable: null as Table | null,
    selectedTableIndex: 0,
  }),

  actions: {
    order() {
      this.showOrder = true
    },
  },
})
