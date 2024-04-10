<template>
  <div class="bg-slate-50 rounded-lg shadow-sm p-6 m-6">
    <CategoryFilter />
    <CategoryDataTable />

    <Dialog
      v-model:visible="category.showForm"
      :header="`${category.isEdit ? ' Edit' : 'New'} Category`"
      :style="{ width: '30rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="category.close()"
    >
      <CategoryForm />
    </Dialog>

    <Toast position="top-right" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import CategoryForm from './CategoryForm.vue'
import CategoryFilter from './CategoryFilter.vue'
import CategoryDataTable from './CategoryDataTable.vue'
import { useCategoryStore } from '@/domain/category/store/index'

const props = defineProps({
  data: Array,
})

const category = useCategoryStore()

onMounted(() => (category.data = props.data as any[]))
</script>
