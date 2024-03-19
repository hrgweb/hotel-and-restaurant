<template>
  <div>
    <!-- Error -->
    <Message v-if="table.errorMsg" severity="error" :closable="false">{{
      table.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <div class="formgrid grid">
        <div class="field col">
          <label for="prefix">Prefix</label>
          <InputText
            id="prefix"
            v-model="form.prefix"
            placeholder="e.g Table"
          />
        </div>
        <div class="field col">
          <label for="name">Name</label>
          <InputText id="name" v-model="form.name" />
        </div>
      </div>
      <div class="field col">
        <Button v-if="!table.isEdit" label="Save" type="submit" />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          @click.prevent="update"
        />
        <Button
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
