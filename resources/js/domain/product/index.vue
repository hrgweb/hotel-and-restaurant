<template>
  <div>
    <ProductFilter />
    <br />
    <ProductDataTable />

    <Dialog
      v-model:visible="product.showForm"
      :header="`${product.isEdit ? ' Edit' : 'New'} Product`"
      :style="{ width: '35rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="product.close()"
    >
      <ProductForm />
    </Dialog>

    <Toast position="top-right" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import ProductForm from './ProductForm.vue'
import ProductFilter from './ProductFilter.vue'
import ProductDataTable from './ProductDataTable.vue'
import { useProductStore } from '@/domain/product/store/index'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
  categories: {
    type: [Array, Object],
    required: true,
  },
})

const product = useProductStore()

onMounted(() => {
  product.data = props.data as any[]
  product.categories = props.categories as any[]
})
</script>
