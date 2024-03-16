import { defineStore } from 'pinia'

// @ts-ignore
import type { Category } from '@/types/category.ts'

export const useCategoryStore = defineStore('category', {
  state: () => ({
    data: [] as Category[],
  }),

  actions: {},
})
