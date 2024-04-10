type OrderItem = {
  order_id?: number
  product_id: number | undefined
  product_name?: string
  price: number
  qty: number
  subtotal: number
}

export type { OrderItem }
