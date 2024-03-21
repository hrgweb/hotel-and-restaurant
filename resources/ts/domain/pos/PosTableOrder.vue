<template>
  <div class="grid table-order">
    <!-- Filter by categories -->
    <div class="col-fixed mx-2" style="width: 200px">
      <Button
        label="All Categories"
        severity="secondary"
        class="w-full mb-1"
        style="height: 60px"
        raised
        @click.prevent="pos.onFilterByAllCategories()"
      />

      <template v-for="category in pos.categories">
        <Button
          :label="category?.name"
          severity="secondary"
          class="w-full mb-1"
          style="height: 60px"
          raised
          @click.prevent="pos.onFilterByCategory(category)"
        />
      </template>
    </div>

    <!-- List of products -->
    <div class="col">
      <div class="flex flex-wrap">
        <template v-for="product in listOfProducts">
          <Card
            style="width: 14rem; height: 16rem; cursor: pointer"
            class="mr-3 mb-3"
            @click="pos.addOrder(product)"
          >
            <template #title>{{ product?.name }}</template>
          </Card>
        </template>
      </div>
    </div>

    <!-- Items added to orders -->
    <div class="col-fixed" id="view-order">
      <div
        class="view-order p-3"
        style="width: 350px; height: 100vh; background-color: #fff"
      >
        <template v-for="order in pos.orders">
          <div>
            <span>{{ order.product.name }}</span> -
            <span>{{ order.qty }}</span>
          </div>
        </template>

        <Button label="Order" @click.prevent="pos.order()" />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { computed } from 'vue'

const pos = usePosStore()

const listOfProducts = computed(() =>
  !pos.hasFilteredByCategory ? pos.products : pos.filteredProductsByCategory
)
</script>

<style lang="scss">
.table-order {
  button {
    text-transform: capitalize;
  }

  #view-order.col-fixed {
    padding: 0 !important;
  }
}
</style>
