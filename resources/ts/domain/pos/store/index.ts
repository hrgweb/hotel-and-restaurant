import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'

export const usePosStore = defineStore('pos', {
  state: () => ({
    resource: 'pos',
    tables: [] as Table[],
    showOrder: false,
  }),

  actions: {
    order() {
      this.showOrder = true
    },
  },
})
