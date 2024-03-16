<template>
  <div>
    <!-- Error -->
    <Message v-if="errorMsg" severity="error" :closable="false">{{
      errorMsg
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
import { reactive, ref } from 'vue'

const form = reactive({
  name: '',
  desc: '',
  thumbnail: null as Blob | null,
})
const errorMsg = ref('')

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.thumbnail = e.files[0]
  hasThumbnail.value = true
}

const emit = defineEmits(['dialog-close'])

function save() {
  errorMsg.value = ''

  let formData = new FormData()
  formData.append('name', form.name)
  formData.append('desc', form.desc)

  if (hasThumbnail.value) {
    formData.append('thumbnail', form.thumbnail)
  }

  axios
    .post('/categories', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })
    .then((response) => {
      form.name = ''
      form.desc = ''
      form.thumbnail = null

      emit('dialog-close')
    })
    .catch((error) => {
      errorMsg.value = error?.response?.data
      console.error(error) // Handle error
    })
}
</script>
