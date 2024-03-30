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
        <label for="category">Category</label>
        <Dropdown
          v-model="product.selectedCategory"
          :options="product.categories"
          optionLabel="name"
          placeholder="Select a City"
          class="w-full"
        />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="barcode">Barcode</label>
        <InputText id="barcode" v-model="form.barcode" />
      </div>
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
        <label for="price">Price</label>
        <InputText id="price" v-model="form.price" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="available">Available</label>
        <InputSwitch v-model="form.available" />
      </div>
      <br />
      <div>
        <!-- Error -->
        <Message v-if="product.errorMsg" severity="error" :closable="false">{{
          product.errorMsg
        }}</Message>
      </div>

      <div class="flex flex-column gap-2">
        <Button
          v-if="!product.isEdit"
          label="Save"
          type="submit"
          :loading="product.loading"
        />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          :loading="product.loading"
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
import { useProductStore } from '@/domain/product/store/index'

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
