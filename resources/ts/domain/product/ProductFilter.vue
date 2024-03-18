<template>
  <div class="flex justify-content-between">
    <Button label="New Category" @click="product.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="product.query"
        @keyup.enter="product.search()"
        placeholder="Search for category name"
        id="query"
      />
      <Button
        label="Clear"
        size="small"
        severity="danger"
        text
        @click.prevent="product.clearSearch()"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useProductStore } from '@/store/product'

const product = useProductStore()
</script>
