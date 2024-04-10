<template>
  <div class="flex justify-between mb-6">
    <Button label="New Role" @click="role.new()" class="mr-1" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="role.query"
        @keyup="search()"
        placeholder="Search for role name"
        id="query"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useRoleStore } from '@/domain/role/store/index'
import { useDebounce } from '@/composables/useDebounce'

const role = useRoleStore()
const { execute } = useDebounce(role.search, 500)

const search = () => execute(role.search)
</script>
