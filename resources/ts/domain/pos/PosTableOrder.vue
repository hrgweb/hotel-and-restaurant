<template>
  <div>
    <pre>{{ pos.selectedTable }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'

const pos = usePosStore()
</script>
