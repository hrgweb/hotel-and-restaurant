<template>
  <div class="tables grid">
    <div class="col">
      <div class="flex flex-wrap px-3">
        <template
          v-for="(table, i) in pos.tables"
          :key="table.id"
          class="table"
        >
          <PosTableItem :table="table" :index="i" />
        </template>
      </div>
    </div>

    <div class="col-fixed">
      <div class="order col-fixed" style="width: 390px; height: 100vh">
        view order
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import PosTableItem from './../PosTableItem.vue'
import { usePosStore } from '@/domain/pos/store'

const pos = usePosStore()
</script>

<style lang="scss">
.tables {
  .order {
    background-color: #fff;
  }

  .col-fixed {
    padding: 0 !important;
  }
}
</style>
