<template>
  <div class="flex justify-content-between">
    <Button label="New Role" @click="role.new()" class="mr-1" />

    <IconField iconPosition="left">
      <InputIcon class="pi pi-search"> </InputIcon>
      <InputText
        v-model="role.query"
        @keyup.enter="role.search()"
        placeholder="Search for role name"
        id="query"
      />
      <Button
        label="Clear"
        size="small"
        severity="danger"
        text
        @click.prevent="role.clearSearch()"
      />
    </IconField>
  </div>
</template>

<script setup lang="ts">
import { useRoleStore } from '@/domain/role/store/index'

const role = useRoleStore()
</script>
