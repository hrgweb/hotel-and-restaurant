import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'
import type { Category } from '@/domain/category/types'
import type { Product } from '@/domain/product/types'
import type { Order } from '@/domain/pos/types'
import { nextTick } from 'vue'

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
    tabsActiveIndex: 0,
    viewPerTableOrders: [] as Order[],
  }),

  actions: {
    openOrder() {
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
        const order = this.orders[foundIndex]
        order.qty += 1
        order.subTotal = order?.product?.price * order?.qty
        return
      }

      const qty = 1
      this.orders.push({
        product,
        qty: qty,
        subTotal: product?.price * qty,
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

    order() {
      const data = {
        orders: this.orders,
        table: this.selectedTable,
      }

      axios
        .post('/orders', data)
        .then(async ({ data }) => {
          if (data && data.length) {
            this.tables[this.selectedTableIndex].vacant = data[0]
            this.tables[this.selectedTableIndex].orders = data
          }
          this.orders = []
          await nextTick()
          this.openTable()
        })
        .catch((error) => {
          console.error(error)
        })
    },

    openTable() {
      document.getElementById('table')?.click()
      this.tabsActiveIndex = 1 // table
      this.showOrder = false
      this.viewPerTableOrders = []
    },

    async cancelOrder() {
      this.orders = []
      await nextTick()
      this.openTable()
    },

    totalCost() {
      // No orders then exit
      if (this.orders.length <= 0) return 0

      let total = 0
      this.orders.forEach((order: Order) => {
        total += order?.subTotal
      })
      return total
    },
  },
})
