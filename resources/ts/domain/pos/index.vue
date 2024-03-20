<template>
  <div class="pos">
    <div class="header">
      <Button
        label="Home"
        class="home"
        id="home"
        severity="info"
        icon="pi pi-home"
        @click="componentToShow('home')"
      />
      <Button
        label="Table"
        class="table"
        id="table"
        severity="info"
        icon="pi pi-table"
        @click="componentToShow('table')"
      />
      <Button
        label="Takeaway"
        class="takeaway"
        id="takeaway"
        severity="info"
        icon="pi pi-gift"
      />
      <Button
        label="Delivery"
        class="delivery"
        id="delivery"
        severity="info"
        icon="pi pi-credit-card"
      />
    </div>

    <div class="main">
      <component :is="view" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { onMounted, shallowRef, watch } from 'vue'
import { usePosStore } from '@/domain/pos/store'
import PosHome from '@/domain/pos/tabs/PosHome.vue'
import PosTable from '@/domain/pos/tabs/PosTable.vue'
import PosTableOrder from '@/domain/pos/PosTableOrder.vue'

const pos = usePosStore()

const props = defineProps({
  tables: Array,
  categories: Array,
  products: Array,
})

watch(
  () => pos.showOrder,
  (newVal) => {
    if (newVal) {
      view.value = PosTableOrder
    }
  }
)

onMounted(() => {
  pos.tables = props.tables
  pos.categories = props.categories
  pos.products = props.products
})

let view = shallowRef(PosHome)

const componentToShow = (name: string) => {
  pos.showOrder = false

  let comp = null

  switch (name) {
    case 'table':
      comp = PosTable
      break

    default:
      comp = PosHome
      break
  }

  view.value = comp
}
</script>

<style lang="scss">
.pos {
  background: #e3e3e3;

  .header {
    position: fixed;
    background-color: rgb(13 83 119);
    top: 0;
    left: 0;
    right: 0;
    padding: 0 0.3rem 0.5rem;
    z-index: 10;

    button {
      width: 200px !important;
      height: 60px !important;
      text-align: left;
      margin-right: 0.3rem;
    }
  }

  .tables {
    display: flex;
    flex-wrap: wrap;
  }

  .main {
    height: 100vh;
    padding-top: 4.7rem;
  }
}
</style>
