<template>
  <div class="flex justify-between mb-6">
    <Button label="New Product" @click="product.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="product.query"
        @keyup="search()"
        placeholder="Search for product name"
        id="query"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useProductStore } from '@/domain/product/store/index'
import { useDebounce } from '@/composables/useDebounce'

const product = useProductStore()
const { execute } = useDebounce(product.search, 500)

const search = () => execute(product.search)
</script>
