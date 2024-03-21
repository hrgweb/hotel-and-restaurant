<template>
  <div class="tables grid">
    <div class="col">
      <div class="flex flex-wrap">
        <template
          v-for="(table, i) in pos.tables"
          :key="table.id"
          class="table"
        >
          <PosTableItem
            :table="table"
            :index="i"
            :available="table.vacant ? false : true"
          />
        </template>
      </div>
    </div>

    <div class="col-fixed">
      <div class="order col-fixed" style="width: 390px; height: 100vh">
        <div v-if="pos.viewPerTableOrders.length" class="p-3">
          <div
            class="reference-no flex justify-content-between"
            style="padding-bottom: 0.5rem; border-bottom: 2px dotted gray"
          >
            <span class="left">Order Reference No:</span>
            <span class="right">{{
              pos.viewPerTableOrders[0].reference_no
            }}</span>
          </div>
          <br />
          <div class="orders">
            <div v-for="order in pos.viewPerTableOrders">
              <div class="flex justify-content-between">
                <span class="left">Item</span>
                <span>
                  <span class="right capitalize pr-2">{{
                    order?.product_name
                  }}</span>
                  <span>x{{ order?.qty }}</span>
                </span>
              </div>
              <div
                class="flex justify-content-between mb-2"
                style="padding-bottom: 0.5rem; border-bottom: 1px solid silver"
              >
                <span class="left">Price</span>
                <span class="right">{{ order?.price }}</span>
              </div>
            </div>
          </div>
          <div class="order-footer mt-3">
            <div class="flex justify-content-between mb-1">
              <span class="left">Subtotal</span>
              <span class="right">{{ subTotal }}</span>
            </div>
            <div class="flex justify-content-between mb-1">
              <span class="left">Order Created Time</span>
              <span class="right">{{
                dayjs(pos.viewPerTableOrders[0].created_at).format(
                  'YYYY-MM-DD hh:mm:ss A'
                )
              }}</span>
            </div>
            <div class="flex justify-content-between mb-1">
              <span class="left">Order Status</span>
              <span class="right">Pending</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import PosTableItem from './../PosTableItem.vue'
import { usePosStore } from '@/domain/pos/store'
import { computed } from 'vue'
import dayjs from 'dayjs'

const pos = usePosStore()

const subTotal = computed(() => {
  let result = pos.viewPerTableOrders.reduce(
    (acc, order) => acc + order?.subtotal,
    0
  )
  return result ? result.toFixed(2) : 0
})
</script>

<style lang="scss">
.tables {
  .order {
    background-color: #fff;
  }

  .col-fixed {
    padding: 0 !important;
  }

  .orders,
  .order-footer {
    span {
      font-size: 0.9rem !important;
    }
  }
}
</style>
