<template>
  <div class="tables flex">
    <div v-for="(table, i) in pos.tables" :key="table.id" class="table">
      <PosTableItem :table="table" :index="i" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import PosTableItem from './../PosTableItem.vue'
import { usePosStore } from '@/domain/pos/store'

const pos = usePosStore()
</script>
