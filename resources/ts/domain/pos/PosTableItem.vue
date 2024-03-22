<template>
  <Card
    style="width: 13rem; height: 6rem; cursor: pointer"
    :style="`${
      table?.status === 'occupied' ? 'background: #F87171; color: #fff' : ''
    }`"
    class="mr-2 mb-2"
    @click="openOrder"
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
})

const openOrder = () => {
  // Chck if table is not available then view order
  if (props.table?.status === 'occupied') {
    pos.orderItem = props?.table?.order
    pos.viewPerTableOrders = props?.table?.order?.items
    pos.selectedTable = props?.table
    pos.selectedTableIndex = props?.index
    return
  }

  // Table is available
  pos.selectedTable = props?.table
  pos.selectedTableIndex = props?.index
  pos.openOrder()
}
</script>
