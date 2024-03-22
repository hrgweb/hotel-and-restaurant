<template>
  <Card
    :class="tableColor"
    class="mr-2 mb-2"
    style="width: 13rem; height: 6rem; cursor: pointer"
    @click="openOrder"
  >
    <template #title>{{ tableName }}</template>
  </Card>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { usePosStore } from '@/domain/pos/store'
import { TableStatus } from '@/enums/tableStatus'
import { OrderStatus } from '@/enums/orderStatus'

const pos = usePosStore()

const tableName = computed(() => `${props.table?.prefix} ${props.table?.name}`)

const tableColor = computed(() => {
  if (props.table?.order?.status === OrderStatus.PROCESS) {
    return 'bg-yellow-500 text-white'
  }

  if (props.table?.status === TableStatus.OCCUPIED) {
    return 'bg-red-500 text-white'
  }
})

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
    pos.orderStatus = pos.selectedTable?.order?.status
    return
  }

  // Table is available
  pos.selectedTable = props?.table
  pos.selectedTableIndex = props?.index
  pos.openOrder()
}
</script>
