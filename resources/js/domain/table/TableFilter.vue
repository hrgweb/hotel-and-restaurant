<template>
  <div class="flex justify-between mb-6">
    <div class="space-x-2">
      <Button label="New Table" @click="table.new()" class="mr-1" />
      <Button
        label="Create Bulk Table"
        severity="info"
        @click="table.createBulk()"
      />
    </div>

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="table.query"
        @keyup="search()"
        placeholder="Search for table name"
        id="query"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useTableStore } from '@/domain/table/store/index'
import { useDebounce } from '@/composables/useDebounce'

const table = useTableStore()
const { execute } = useDebounce(table.search, 500)

const search = () => execute(table.search)
</script>
