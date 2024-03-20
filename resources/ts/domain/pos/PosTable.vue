<template>
  <Card style="width: 12rem; height: 6rem; cursor: pointer" class="mr-2 mb-2">
    <template #title>{{ tableName }}</template>
  </Card>
</template>

<script lang="ts" setup>
import { computed } from 'vue'

const tableName = computed(() => `${props.table?.prefix} ${props.table?.name}`)

const props = defineProps({
  table: {
    type: Object,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
})
</script>
