<template>
  <div>
    <DataTable :value="category.data" tableStyle="min-width: 50rem">
      <Column header="Image">
        <template #body="{ data }">
          <img
            v-if="useImageSrc(data.thumbnail)"
            :src="useImageSrc(data.thumbnail)"
            :alt="data.image"
            class="w-6rem border-round"
          />
          <img
            v-else
            :src="useImageSrc('default.png')"
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
          <Button icon="pi pi-times" severity="danger" />
        </template>
      </Column>
    </DataTable>
  </div>
</template>

<script lang="ts" setup>
import { useCategoryStore } from '@/store/category.ts'
import { useImageSrc } from '@/composables/useImageSrc.ts'

const category = useCategoryStore()
</script>
