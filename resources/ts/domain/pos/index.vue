<template>
  <div>
    <TabView
      :activeIndex="pos.tabsActiveIndex"
      class="tabview-custom"
      @tab-click="componentToShow"
    >
      <!-- Home -->
      <TabPanel>
        <template #header>
          <div class="flex align-items-center gap-2">
            <Avatar icon="pi pi-home" shape="circle" />
            <span class="font-bold white-space-nowrap">Home</span>
          </div>
        </template>
        <PosHome />
      </TabPanel>
      <!-- Table -->
      <TabPanel>
        <template #header>
          <div class="flex align-items-center gap-2">
            <Avatar icon="pi pi-table" shape="circle" />
            <span class="font-bold white-space-nowrap">Table</span>
          </div>
        </template>
        <component :is="view" />
      </TabPanel>
      <!-- Takeaway -->
      <TabPanel>
        <template #header>
          <div class="flex align-items-center gap-2">
            <Avatar icon="pi pi-gift" shape="circle" />
            <span class="font-bold white-space-nowrap">Takeaway</span>
            <Badge value="2" />
          </div>
        </template>
        <p class="m-0">take out</p>
      </TabPanel>
      <!-- Delivery -->
      <TabPanel>
        <template #header>
          <div class="flex align-items-center gap-2">
            <Avatar icon="pi pi-credit-card" shape="circle" />
            <span class="font-bold white-space-nowrap">Delivery</span>
          </div>
        </template>
        <p class="m-0">deliver</p>
      </TabPanel>
    </TabView>

    <!-- Popup dialog -->
    <ConfirmPopup></ConfirmPopup>

    <!-- Toast -->
    <Toast position="bottom-center" />
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
    } else {
      view.value = PosTable
    }
  }
)

onMounted(() => {
  pos.tables = props.tables
  pos.categories = props.categories
  pos.products = props.products
})

const view = shallowRef(PosTable)
const componentToShow = () => {
  pos.showOrder = false
  pos.viewPerTableOrders = []
}
</script>

<style lang="scss">
.p-tabview-panels {
  background-color: #e3e3e3 !important;
  padding: 0.5rem !important;
}

.pos {
  background: #e3e3e3;
}
</style>
