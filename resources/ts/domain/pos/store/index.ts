import { defineStore } from 'pinia'
import type { Table } from '@/domain/table/types'
import type { Category } from '@/domain/category/types'
import type { Product } from '@/domain/product/types'
import type { Order } from '@/domain/pos/types/order'
import type { OrderItem } from '@/domain/pos/types/orderItem'
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
    orderItem: null as Order | null,
    orderItems: [] as OrderItem[],
    filteredProductsByCategory: [] as Product[],
    hasFilteredByCategory: false,
    tabsActiveIndex: 0,
    viewPerTableOrders: [] as OrderItem[],
    showAboutToOrder: false,
    orderType: '',
  }),

  actions: {
    openOrder() {
      this.showOrder = true
    },

    existOrderIndex(product: Product) {
      // If no order items return -1 as not found
      if (this.orderItems.length <= 0) return -1

      return this.orderItems.findIndex(
        (item: Order) => item.product.id === product.id
      )
    },

    addOrder(product: Product) {
      // Check if product is added, then add qty by 1
      const foundIndex = this.existOrderIndex(product)

      if (foundIndex !== -1) {
        const order = this.orderItems[foundIndex]
        order.qty += 1
        order.subTotal = order?.product?.price * order?.qty
        return
      }

      const qty = 1
      this.orderItems.push({
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

    aboutToOrder() {
      this.showAboutToOrder = true
    },

    submitOrder(orderType: string) {
      this.orderType = orderType

      const data = {
        orderItems: this.orderItems,
        table: this.selectedTable,
        type: orderType,
      }

      axios
        .post('/orders', data)
        .then(async ({ data }) => {
          if (data && data.order) {
            this.tables[this.selectedTableIndex].status = 'occupied'
            this.tables[this.selectedTableIndex].order = data?.order
            this.tables[this.selectedTableIndex].order.items = data?.orderItems
          }
          this.orderItems = []
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
      this.orderItems = []
      await nextTick()
      this.openTable()
    },

    totalCost() {
      // No order items then exit
      if (this.orderItems.length <= 0) return 0

      let total = 0
      this.orderItems.forEach((order: Order) => {
        total += order?.subTotal
      })
      return total
    },
  },
})
