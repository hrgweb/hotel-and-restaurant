<template>
  <div class="flex justify-content-between">
    <Button label="New Category" @click="category.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="category.query"
        @keyup.enter="category.search()"
        placeholder="Search for category name"
        id="query"
      />
      <Button
        label="Clear"
        size="small"
        severity="danger"
        text
        @click.prevent="category.clearSearch()"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useCategoryStore } from '@/domain/category/store/index'

const category = useCategoryStore()
</script>
