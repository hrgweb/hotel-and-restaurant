<template>
  <div>
    <Button label="New Category" @click="showForm = !showForm" />

    <Dialog
      v-model:visible="showForm"
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
import { ref } from 'vue'
import CategoryForm from './CategoryForm.vue'

// @ts-ignore
import { useCategoryStore } from '@/store/category.ts'

const category = useCategoryStore()

const showForm = ref(false)

function closed() {
  showForm.value = false
}
</script>
