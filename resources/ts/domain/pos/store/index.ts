import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'
import type { Category } from '@/domain/category/types'
import type { Product } from '@/domain/product/types'
import type { Order } from '@/domain/pos/types'

export const usePosStore = defineStore('pos', {
  state: () => ({
    resource: 'pos',
    tables: [] as Table[],
    categories: [] as Category[],
    products: [] as Product[],
    showOrder: false,
    selectedTable: null as Table | null,
    selectedTableIndex: 0,
    orders: [] as Order[],
    filteredProductsByCategory: [] as Product[],
    hasFilteredByCategory: false,
  }),

  actions: {
    order() {
      this.showOrder = true
    },

    existOrderIndex(product: Product) {
      // If no orders return -1 as not found
      if (this.orders.length <= 0) return -1

      return this.orders.findIndex(
        (order: Order) => order.product.id === product.id
      )
    },

    addOrder(product: Product) {
      // Check if product is added, then add qty by 1
      const foundIndex = this.existOrderIndex(product)

      if (foundIndex !== -1) {
        this.orders[foundIndex].qty += 1
        return
      }

      this.orders.push({
        product,
        qty: 1,
      })
    },

    onFilterByCategory(category: Category) {
      this.hasFilteredByCategory = true

      this.filteredProductsByCategory = this.products.filter(
        (product: Product) => product.category_id === category.id
      )
    },

    onFilterByAllCategories() {
      this.hasFilteredByCategory = false
    },
  },
})
