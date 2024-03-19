<template>
  <div>
    <DataTable
      :value="data"
      tableStyle="min-width: 50rem"
      :stripedRows="true"
      size="small"
    >
      <Column field="role" header="Role"></Column>
      <Column header="Action">
        <template #body="{ data, index }">
          <Button
            icon="pi pi-pencil"
            severity="warning"
            class="mr-1"
            @click.prevent="role.edit(data, index)"
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
import { useRoleStore } from '@/domain/role/store'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'
import type { Table } from '@/types/role'

const role = useRoleStore()
const confirm = useConfirm()
const toast = useToast()

const data = computed(() => (!role.isSearch ? role.data : role.searchResult))

const confirmRemove = (data: Table, index: number, event: any) => {
  role.askRemove(data, index)
  confirm.require({
    target: event.currentTarget,
    message: `Are you sure you want to remove '${data?.role}'?`,
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => {
      role
        .remove()
        .then(({ data: Table }) => {
          role.data.splice(role.index, 1)
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
