<template>
  <div class="pos grid">
    <div class="col-12 header" style="background-color: rgb(13 83 119)">
      <Button
        label="Home"
        class="home"
        severity="info"
        icon="pi pi-home"
        @click="componentToShow('home')"
      />
      <Button
        label="Table"
        class="home"
        severity="info"
        icon="pi pi-table"
        @click="componentToShow('table')"
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
      <div class="main">
        <component :is="view" />
      </div>
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

.tables {
  display: flex;
  flex-wrap: wrap;
}

.main {
  height: 100vh;
}
</style>
