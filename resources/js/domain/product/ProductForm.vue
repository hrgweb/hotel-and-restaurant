<template>
  <div class="pb-3">
    <!-- Error -->
    <Message v-if="product.errorMsg" severity="error" :closable="false">{{
      product.errorMsg
    }}</Message>

    <form
      class="space-y-3"
      enctype="multipart/form-data"
      @submit.prevent="save"
    >
      <FileUpload
        mode="basic"
        name="thumbnail[]"
        accept="image/*"
        :maxFileSize="100000000"
        @select="selectedThumbnail($event)"
      />
      <div class="flex flex-col">
        <label for="category">Category</label>
        <Dropdown
          v-model="product.selectedCategory"
          :options="product.categories"
          optionLabel="name"
          placeholder="Select a City"
          class="w-full"
        />
      </div>
      <div class="flex flex-col">
        <label for="barcode">Barcode</label>
        <InputText id="barcode" v-model="form.barcode" />
      </div>
      <div class="flex flex-col">
        <label for="name">Name</label>
        <InputText id="name" v-model="form.name" />
      </div>
      <div class="flex flex-col">
        <label for="desc">Description</label>
        <InputText id="desc" v-model="form.desc" />
      </div>
      <div class="flex space-x-3 items-center">
        <div class="w-6/12 flex flex-col">
          <label for="price">Price</label>
          <InputText id="price" v-model="form.price" />
        </div>
        <div class="w-6/12 flex flex-col">
          <label for="available">Available</label>
          <InputSwitch v-model="form.available" />
        </div>
      </div>

      <div class="flex flex-row space-x-2" style="margin-top: 20px">
        <Button
          v-if="!product.isEdit"
          label="Save"
          type="submit"
          :loading="product.loading"
          class="w-20"
        />
        <Button
          v-else
          label="Update"
          class="w-20"
          type="button"
          severity="info"
          :loading="product.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          class="w-20"
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
