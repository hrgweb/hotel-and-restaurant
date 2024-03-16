<template>
  <div>
    <!-- Error -->
    <Message v-if="category.errorMsg" severity="error" :closable="false">{{
      category.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <FileUpload
        name="thumbnail"
        :multiple="false"
        accept="image/*"
        :maxFileSize="1000000"
        :show-upload-button="false"
        :show-cancel-button="false"
        @select="selectedThumbnail($event)"
      >
        <template #empty>
          <p>Drag and drop a file here to upload.</p>
        </template>
      </FileUpload>
      <br />
      <div class="flex flex-column gap-2">
        <label for="name">Name</label>
        <InputText id="name" v-model="form.name" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="desc">Description</label>
        <InputText id="desc" v-model="form.desc" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <Button v-if="!category.isEdit" label="Save" type="submit" />
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
          @click.prevent="category.cancel()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'

// @ts-ignore
import { useCategoryStore } from '@/store/category'

const category = useCategoryStore()

const form = computed(() =>
  !category.isEdit ? category.form : category.editForm
)

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.value.thumbnail = e.files[0]
  hasThumbnail.value = true
}

function save() {
  category.save(hasThumbnail.value)
}

function update() {
  category.update(hasThumbnail.value)
}
</script>
