<template>
  <div>
    <DataTable
      :value="data"
      tableStyle="min-width: 50rem"
      :stripedRows="true"
      size="small"
    >
      <Column header="Image">
        <template #body="{ data }">
          <img
            v-if="data.thumbnail"
            :src="useImageSrc(data.thumbnail)"
            :alt="data.image"
            class="w-6rem border-round"
            height="96"
            width="96"
          />
          <img
            v-else
            :src="useImageSrc('default.png')"
            :alt="data.image"
            class="w-6rem border-round"
            height="96"
            width="96"
          />
        </template>
      </Column>
      <Column field="name" header="Name"></Column>
      <Column field="desc" header="Description"> </Column>
      <Column header="Action">
        <template #body="{ data, index }">
          <Button
            icon="pi pi-pencil"
            severity="warning"
            class="mr-1"
            @click.prevent="category.edit(data, index)"
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
import { useCategoryStore } from '@/domain/category/store/index'
import { useImageSrc } from '@/composables/useImageSrc'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'
import type { Category } from '@/types/category'

const category = useCategoryStore()
const confirm = useConfirm()
const toast = useToast()

const data = computed(() =>
  !category.isSearch ? category.data : category.searchResult
)

const confirmRemove = (data: Category, index: number, event: any) => {
  category.askRemove(data, index)
  confirm.require({
    target: event.currentTarget,
    message: `Are you sure you want to remove '${data?.name}'?`,
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => {
      category
        .remove()
        .then(({ data: Category }) => {
          category.data.splice(category.index, 1)
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