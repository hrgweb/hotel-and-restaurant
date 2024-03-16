<template>
  <div>
    <!-- Error -->
    <Message v-if="category.errorMsg" severity="error" :closable="false">{{
      category.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" method="POST" @submit.prevent="save">
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
        <Button label="Save" type="submit" />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'

// @ts-ignore
import { useCategoryStore } from '@/store/category'

const category = useCategoryStore()

const form = computed(() => category.form)

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  category.form.thumbnail = e.files[0]
  hasThumbnail.value = true
}

function save() {
  category.save(hasThumbnail.value)
}
</script>
