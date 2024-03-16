<template>
  <div>
    <Button label="New Category" @click="category.new()" />

    <CategoryDataTable />

    <Dialog
      v-model:visible="category.showForm"
      :header="`${category.isEdit ? ' Edit' : 'New'} Category`"
      :style="{ width: '35rem' }"
      :dismissableMask="true"
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
import CategoryDataTable from './CategoryDataTable.vue'
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
