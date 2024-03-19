<template>
  <div>
    <!-- Error -->
    <Message v-if="table.errorMsg" severity="error" :closable="false">{{
      table.errorMsg
    }}</Message>

    <form @submit.prevent="save">
      <div class="flex">
        <div class="flex flex-column mr-3">
          <label for="prefix">Prefix</label>
          <InputText
            id="prefix"
            v-model="form.prefix"
            placeholder="e.g Table"
          />
        </div>
        <br />

        <div v-if="!table.isBulk" class="flex flex-column">
          <label for="name">Name</label>
          <InputText id="name" v-model="form.name" placeholder="e.g 1" />
        </div>
        <div v-else class="flex flex-column">
          <label for="bulkOfTable">No of Table</label>
          <InputText id="bulkOfTable" v-model="form.bulkOfTable" />
        </div>
      </div>
      <br />
      <div>
        <Button v-if="!table.isEdit" label="Save" type="submit" />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          @click.prevent="update"
        />
        <Button
          class="ml-1"
          label="Cancel"
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

<style lang="scss" scoped>
form {
  & label {
    padding-bottom: 0.6rem;
  }
}
</style>
