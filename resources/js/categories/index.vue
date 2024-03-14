<template>
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
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'

const form = reactive({
  name: '',
  desc: '',
  thumbnail: null,
})

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.thumbnail = e.files[0]
  hasThumbnail.value = true
}

function save() {
  let formData = new FormData()
  formData.append('name', form.name)
  formData.append('desc', form.desc)

  if (hasThumbnail.value) {
    formData.append('thumbnail', form.thumbnail)
  }

  axios
    .post('/categories', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    .then((response) => {
      console.log(response.data) // Handle success

      // Optionally reset the form fields
      // this.formData.name = ''
      // this.formData.email = ''
      // this.formData.file = null
    })
    .catch((error) => {
      console.error(error) // Handle error
    })
}
</script>
