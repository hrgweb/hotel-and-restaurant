<template>
  <DataTable :value="data" :stripedRows="true" :unstyled="true">
    <Column header="Image">
      <template #body="{ data }">
        <img
          v-if="data.thumbnail"
          :src="String(useImageSrc(data.thumbnail))"
          :alt="data.image"
          class="w-6rem border-round"
        />
        <img
          v-else
          :src="String(useImageSrc('default.png'))"
          :alt="data.image"
          class="w-6rem border-round"
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
        .then(() => {
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

<style>
img {
  object-fit: cover;
  @apply w-24 h-20;
}
</style>
