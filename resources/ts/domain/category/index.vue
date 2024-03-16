<template>
  <div>
    <CategoryFilter />
    <br />
    <CategoryDataTable />

    <Dialog
      v-model:visible="category.showForm"
      :header="`${category.isEdit ? ' Edit' : 'New'} Category`"
      :style="{ width: '35rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="category.close()"
    >
      <CategoryForm />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import CategoryForm from './CategoryForm.vue'
import CategoryFilter from './CategoryFilter.vue'
import CategoryDataTable from './CategoryDataTable.vue'
import { useCategoryStore } from '@/store/category'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
})

const category = useCategoryStore()

onMounted(() => (category.data = props.data))
</script>
