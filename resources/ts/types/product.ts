type Product = {
  id?: number
  category_id?: number
  thumbnail?: string
  file?: Blob | null
  barcode?: string
  name: string
  desc?: string
  price?: number
  available?: boolean
}

export type { Product }
