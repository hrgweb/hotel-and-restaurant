<template>
  <div class="flex justify-content-between">
    <div>
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
        @keyup.enter="table.search()"
        placeholder="Search for table name"
        id="query"
      />
      <Button
        label="Clear"
        size="small"
        severity="danger"
        text
        @click.prevent="table.clearSearch()"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useTableStore } from '@/domain/table/store/index'

const table = useTableStore()
</script>
