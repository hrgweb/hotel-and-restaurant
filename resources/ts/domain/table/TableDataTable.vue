<template>
  <div>
    <DataTable
      :value="data"
      tableStyle="min-width: 50rem"
      :stripedRows="true"
      size="small"
    >
      <Column field="table_name" header="Name"></Column>
      <Column header="Action">
        <template #body="{ data, index }">
          <Button
            icon="pi pi-pencil"
            severity="warning"
            class="mr-1"
            @click.prevent="table.edit(data, index)"
          />
          <Button
            icon="pi pi-times"
            severity="danger"
            @click.prevent="confirmRemove(data, index, $event)"
          />

          <!-- Ask dialog remove -->
          <ConfirmPopup />
        </template>
      </Column>

      <template #empty>
        <p class="text-center">No record found</p>
      </template>
    </DataTable>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useTableStore } from '@/domain/table/store/index'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'
import type { Table } from '@/types/table'

const table = useTableStore()
const confirm = useConfirm()
const toast = useToast()

const data = computed(() => (!table.isSearch ? table.data : table.searchResult))

const confirmRemove = (data: Table, index: number, event: any) => {
  table.askRemove(data, index)
  confirm.require({
    target: event.currentTarget,
    message: `Are you sure you want to remove '${data?.name}'?`,
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => {
      table
        .remove()
        .then(({ data: Table }) => {
          table.data.splice(table.index, 1)
          toast.add({
            severity: 'success',
            summary: 'Confirmed',
            detail: '1 record successfully removed.',
            life: 3000,
          })
        })
        .catch((error: any) => {
          console.error(error)
        })
    },
  })
}
</script>
