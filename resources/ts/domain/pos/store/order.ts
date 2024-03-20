import type { Product } from '@/domain/product/store'

type Order = {
  product: Product | null
  qty: number
}

export type { Order }
