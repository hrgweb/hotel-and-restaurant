<template>
  <Card
    style="width: 13rem; height: 6rem; cursor: pointer"
    :style="`${!available ? 'background: #F87171; color: #fff' : ''}`"
    class="mr-2 mb-2"
    @click="order"
  >
    <template #title>{{ tableName }}</template>
  </Card>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { usePosStore } from '@/domain/pos/store'

const pos = usePosStore()

const tableName = computed(() => `${props.table?.prefix} ${props.table?.name}`)

const props = defineProps({
  table: Object,
  index: Number,
  available: Boolean,
})

const order = () => {
  // Chck if table is not available then view order
  if (!props.available) {
    pos.viewPerTableOrders = props.table?.orders
    return
  }

  // Table is available
  pos.selectedTable = props?.table
  pos.selectedTableIndex = props?.index
  pos.openOrder()
}
</script>
