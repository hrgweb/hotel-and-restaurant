<template>
  <div>
    <TableFilter />
    <br />
    <TableDataTable />

    <Dialog
      v-model:visible="table.showForm"
      :header="`${table.isEdit ? ' Edit' : 'New'} Table`"
      :style="{ width: '35rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="table.close()"
    >
      <TableForm />
    </Dialog>

    <Toast position="top-right" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import TableForm from './TableForm.vue'
import TableFilter from './TableFilter.vue'
import TableDataTable from './TableDataTable.vue'
import { useTableStore } from '@/domain/table/store/index'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
})

const table = useTableStore()

onMounted(() => (table.data = props.data as any[]))
</script>
