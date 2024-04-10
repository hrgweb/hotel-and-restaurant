<template>
  <div class="flex justify-between pt-6">
    <Button label="New Category" @click="category.new()" />

    <div class="relative">
      <IconField iconPosition="left">
        <InputIcon>
          <i class="pi pi-search" />
        </InputIcon>
        <InputText
          v-model="category.query"
          placeholder="Search for category name"
          id="query"
          @keyup="search()"
        />
      </IconField>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useCategoryStore } from '@/domain/category/store/index'
import { useDebounce } from '@/composables/useDebounce'

const category = useCategoryStore()
const { execute } = useDebounce(category.search, 500)

const search = () => execute(category.search)
</script>
