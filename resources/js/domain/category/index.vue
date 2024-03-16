<template>
  <div>
    <Button
      label="New Category"
      @click="category.showForm = !category.showForm"
    />

    <Dialog
      v-model:visible="category.showForm"
      header="New Category"
      :style="{ width: '35rem' }"
      :dismissableMask="true"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @dialog-close="closed"
    >
      <CategoryForm />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import CategoryForm from './CategoryForm.vue'

// @ts-ignore
import { useCategoryStore } from '@/store/category.ts'

const category = useCategoryStore()
</script>
