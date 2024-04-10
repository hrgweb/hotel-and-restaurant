<template>
  <div class="pb-3">
    <!-- Error -->
    <Message v-if="table.errorMsg" severity="error" :closable="false">{{
      table.errorMsg
    }}</Message>

    <form class="space-y-3" @submit.prevent="save">
      <div class="flex space-x-3 items-center">
        <div class="flex flex-col w-6/12">
          <label for="prefix">Prefix</label>
          <InputText
            id="prefix"
            v-model="form.prefix"
            placeholder="e.g Table"
          />
        </div>

        <div v-if="!table.isBulk" class="flex flex-col w-6/12">
          <label for="name">Name</label>
          <InputText id="name" v-model="form.name" placeholder="e.g 1" />
        </div>
        <div v-else class="flex flex-col w-6/12">
          <label for="bulkOfTable">No of Table</label>
          <InputText
            id="bulkOfTable"
            v-model="form.bulkOfTable"
            type="number"
          />
        </div>
      </div>
      <div class="flex flex-col w-full">
        <label for="capacity">Capacity</label>
        <InputText
          id="capacity"
          v-model="form.capacity"
          placeholder="e.g Table"
          type="number"
        />
      </div>

      <div class="flex flex-row space-x-2" style="margin-top: 20px">
        <Button
          v-if="!table.isEdit"
          class="w-20"
          label="Save"
          type="submit"
          :loading="table.loading"
        />
        <Button
          v-else
          label="Update"
          class="w-20"
          type="button"
          severity="info"
          :loading="table.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          class="w-20"
          type="button"
          severity="secondary"
          @click.prevent="table.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useTableStore } from '@/domain/table/store/index'

const table = useTableStore()

const form = computed(() => (!table.isEdit ? table.form : table.editForm))

function save() {
  table.save()
}

function update() {
  table.update()
}
</script>

<style scoped>
form {
  & label {
    padding-bottom: 0.6rem;
  }
}
</style>
