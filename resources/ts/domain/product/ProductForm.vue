<template>
  <div>
    <!-- Error -->
    <Message v-if="product.errorMsg" severity="error" :closable="false">{{
      product.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <FileUpload
        mode="basic"
        name="thumbnail[]"
        accept="image/*"
        :maxFileSize="100000000"
        @select="selectedThumbnail($event)"
      />
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
        <Button v-if="!product.isEdit" label="Save" type="submit" />
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
          @click.prevent="product.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { useProductStore } from '@/store/product'

const product = useProductStore()

const form = computed(() => (!product.isEdit ? product.form : product.editForm))

const hasThumbnail = ref(false)
function selectedThumbnail(e) {
  form.value.image = e.files[0]
  hasThumbnail.value = true
}

function save() {
  product.save(hasThumbnail.value)
}

function update() {
  product.update(hasThumbnail.value)
}
</script>
