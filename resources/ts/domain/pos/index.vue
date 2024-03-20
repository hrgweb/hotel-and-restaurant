<template>
  <div class="pos grid">
    <div class="col-12 header" style="background-color: gray">
      <Button
        label="Home"
        class="home"
        severity="info"
        icon="pi pi-home"
        @click="view = PosHome"
      />
      <Button
        label="Table"
        class="home"
        severity="info"
        icon="pi pi-table"
        @click="view = PosTable"
      />
      <Button label="Takeaway" class="home" severity="info" icon="pi pi-gift" />
      <Button
        label="Delivery"
        class="home"
        severity="info"
        icon="pi pi-credit-card"
      />
    </div>

    <div class="col-12">
      <div class="grid main">
        <!-- Content -->
        <div class="content col">
          <component :is="view" />
        </div>

        <!-- Order -->
        <div class="order col-fixed" style="width: 350px">order</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, shallowRef } from 'vue'
import { usePosStore } from '@/domain/pos/store'
import PosHome from '@/domain/pos/tabs/PosHome.vue'
import PosTable from '@/domain/pos/tabs/PosTable.vue'

const pos = usePosStore()

const props = defineProps({
  tables: [Array, Object],
})

let view = shallowRef(PosHome)

onMounted(() => (pos.tables = props.tables))
</script>

<style lang="scss">
.pos {
  background: #e3e3e3;
}

.header {
  button {
    margin-right: 0.3rem;
  }
}

button.home {
  width: 200px !important;
  height: 60px !important;
  text-align: left;
}

.main {
  height: 100vh;
}

.tables {
  display: flex;
  flex-wrap: wrap;
}

.order {
  background-color: #fff;
}
</style>
