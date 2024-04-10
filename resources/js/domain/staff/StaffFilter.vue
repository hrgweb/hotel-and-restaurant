<template>
  <div class="flex justify-between mb-6">
    <Button label="New Staff" @click="staff.new()" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="staff.query"
        @keyup="search()"
        placeholder="Search for staff name"
        id="query"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useStaffStore } from '@/domain/staff/store/index'
import { useDebounce } from '@/composables/useDebounce'

const staff = useStaffStore()
const { execute } = useDebounce(staff.search, 500)

const search = () => execute(staff.search)
</script>
