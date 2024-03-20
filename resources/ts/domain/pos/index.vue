<template>
  <div class="pos grid">
    <div class="col-12 header" style="background-color: gray">
      <Button label="Home" class="home" severity="info" icon="pi pi-home" />
      <Button label="Table" class="home" severity="info" icon="pi pi-table" />
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
          <div class="tables flex">
            <div v-for="(table, i) in tables" :key="table.id" class="table">
              <PosTable :table="table" :index="i" />
            </div>
          </div>
        </div>

        <!-- Order -->
        <div class="order col-fixed" style="width: 350px">order</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import PosTable from './PosTable.vue'

const props = defineProps({
  tables: {
    type: [Array, Object],
    required: true,
  },
})
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
