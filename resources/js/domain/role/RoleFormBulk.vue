<template>
  <div>
    <!-- Error -->
    <Message v-if="table.errorMsg" severity="error" :closable="false">{{
      table.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
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
        <div class="flex flex-column">
          <label for="tableNo">No of Table</label>
          <InputText id="tableNo" v-model="form.bulkOfTable" />
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
import { ref, computed } from 'vue'
import { useTableStore } from '@/domain/table/store/index'

const table = useTableStore()

const form = computed(() => (!table.isEdit ? table.form : table.editForm))

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.value.image = e.files[0]
  hasThumbnail.value = true
}

function save() {
  table.save(hasThumbnail.value)
}

function update() {
  table.update(hasThumbnail.value)
}
</script>
