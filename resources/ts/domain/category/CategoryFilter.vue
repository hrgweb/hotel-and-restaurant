<template>
  <div class="flex justify-content-between">
    <Button label="New Category" @click="category.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="category.query"
        @keyup.enter="category.search()"
        placeholder="Search for category name"
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
import { ref } from 'vue'
import { useCategoryStore } from '@/store/category'

const category = useCategoryStore()
</script>
