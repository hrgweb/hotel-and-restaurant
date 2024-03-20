<template>
  <div class="grid order" style="background-color: #e3e3e3">
    <div class="col-fixed mx-2" style="background: rgb(53 53 53); width: 200px">
      <Button
        label="All Categories"
        severity="secondary"
        class="w-full mb-1"
        style="height: 60px"
        raised
      />

      <template v-for="category in pos.categories">
        <Button
          :label="category?.name"
          severity="secondary"
          class="w-full mb-1"
          style="height: 60px"
          raised
        />
      </template>
    </div>

    <div class="col">
      <div class="flex flex-wrap">
        <template v-for="product in pos.products">
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

    <div class="col-fixed" style="">
      <div
        class="p-3"
        style="width: 350px; height: 100vh; background-color: #fff"
      >
        <template v-for="order in pos.orders">
          <div>
            <span>{{ order.product.name }}</span> -
            <span>{{ order.qty }}</span>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'

const pos = usePosStore()
</script>

<style lang="scss">
.order {
  button {
    text-transform: capitalize;
  }
}
</style>
