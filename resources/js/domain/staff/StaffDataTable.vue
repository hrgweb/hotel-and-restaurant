<template>
  <div>
    <DataTable
      :value="data"
      tableStyle="min-width: 50rem"
      :stripedRows="true"
      size="small"
    >
      <Column field="user.name" header="Name"></Column>
      <Column field="user.email" header="Email"></Column>
      <Column field="user.username" header="Username"></Column>
      <Column header="User Role">
        <template #body="{ data }">
          <Badge :value="data?.staff_role?.role" severity="info"></Badge>
        </template>
      </Column>
      <Column header="Action">
        <template #body="{ data, index }">
          <Button
            icon="pi pi-pencil"
            severity="warning"
            class="mr-1"
            @click.prevent="staff.edit(data, index)"
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
import { useStaffStore } from '@/domain/staff/store/index'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'
import type { Staff } from '@/types/staff'

const staff = useStaffStore()
const confirm = useConfirm()
const toast = useToast()

const data = computed(() => (!staff.isSearch ? staff.data : staff.searchResult))

const confirmRemove = (data: Staff, index: number, event: any) => {
  staff.askRemove(data, index)
  confirm.require({
    target: event.currentTarget,
    message: `Are you sure you want to remove '${data?.user?.name}'?`,
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => {
      staff
        .remove()
        .then(({ data: Staff }) => {
          staff.data.splice(staff.index, 1)
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
