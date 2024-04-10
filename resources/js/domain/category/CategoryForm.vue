<template>
  <div class="pb-3">
    <!-- Error -->
    <Message v-if="category.errorMsg" severity="error" :closable="false">{{
      category.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <FileUpload
        mode="basic"
        name="thumbnail[]"
        accept="image/*"
        :maxFileSize="100000000"
        @select="selectedThumbnail($event)"
      />
      <div class="flex flex-col my-3">
        <label for="name">Name</label>
        <InputText id="name" v-model="form.name" />
      </div>
      <div class="flex flex-col mb-6">
        <label for="desc">Description</label>
        <InputText id="desc" v-model="form.desc" />
      </div>
      <div class="flex flex-row space-x-2">
        <Button
          v-if="!category.isEdit"
          label="Save"
          type="submit"
          :loading="category.loading"
          class="w-20"
        />
        <Button
          v-else
          class="w-20"
          label="Update"
          type="button"
          severity="info"
          :loading="category.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          class="w-20"
          type="button"
          severity="secondary"
          @click.prevent="category.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { useCategoryStore } from '@/domain/category/store/index'

const category = useCategoryStore()

const form = computed(() =>
  !category.isEdit ? category.form : category.editForm
)

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.value.image = e.files[0]
  hasThumbnail.value = true
}

function save() {
  category.save(hasThumbnail.value)
}

function update() {
  category.update(hasThumbnail.value)
}
</script>
