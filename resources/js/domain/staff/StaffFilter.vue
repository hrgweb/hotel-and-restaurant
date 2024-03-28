<template>
  <div class="flex justify-content-between">
    <Button label="New Staff" @click="staff.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="staff.query"
        @keyup.enter="staff.search()"
        placeholder="Search for staff name"
        id="query"
      />
      <Button
        label="Clear"
        size="small"
        severity="danger"
        text
        @click.prevent="staff.clearSearch()"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useStaffStore } from '@/domain/staff/store/index'

const staff = useStaffStore()
</script>
