<template>
  <div>
    <Button
      label="New Category"
      @click="category.showForm = !category.showForm"
    />

    <CategoryDataTable />

    <Dialog
      v-model:visible="category.showForm"
      header="New Category"
      :style="{ width: '35rem' }"
      :dismissableMask="true"
      :closeOnEscape="true"
      :draggable="false"
      modal
    >
      <CategoryForm />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import CategoryForm from './CategoryForm.vue'
import CategoryDataTable from './CategoryDataTable.vue'

// @ts-ignore
import { useCategoryStore } from '@/store/category.ts'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
})

const category = useCategoryStore()

onMounted(() => (category.data = props.data))
</script>
