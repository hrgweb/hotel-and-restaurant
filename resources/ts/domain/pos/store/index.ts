import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'

export const usePosStore = defineStore('pos', {
  state: () => ({
    resource: 'pos',
    tables: [] as Table[],
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
