<template>
  <div class="tables grid">
    <!-- list of table -->
    <div class="col">
      <div class="flex flex-wrap">
        <template
          v-for="(table, i) in pos.tables"
          :key="table.id"
          class="table"
        >
          <PosTableItem :table="table" :index="i" />
        </template>
      </div>
    </div>

    <!-- view orders per table -->
    <div class="col-fixed" id="order" style="width: 390px; height: 100vh">
      <div class="col-fixed">
        <div
          v-if="pos.viewPerTableOrders && pos.viewPerTableOrders.length"
          class="p-3"
        >
          <div class="order-header">
            <div class="pb-1 reference-no flex justify-content-between">
              <span class="left">Table No</span>
              <span class="right">{{ pos?.selectedTable?.table_name }}</span>
            </div>
            <div
              class="pb-1 table-no flex justify-content-between"
              style="border-bottom: 2px dotted gray"
            >
              <span class="left">Order Reference No:</span>
              <span class="right">{{ pos?.orderItem?.reference_no }}</span>
            </div>
          </div>
          <br />
          <div class="order-items">
            <div v-for="orderItem in pos.viewPerTableOrders">
              <div class="flex justify-content-between">
                <span class="left">Item</span>
                <span>
                  <span class="right capitalize pr-2">{{
                    orderItem?.product_name
                  }}</span>
                  <span>x{{ orderItem?.qty }}</span>
                </span>
              </div>
              <div
                class="flex justify-content-between mb-2"
                style="padding-bottom: 0.5rem; border-bottom: 1px solid silver"
              >
                <span class="left">Price</span>
                <span class="right">{{ orderItem?.price }}</span>
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
                dayjs(pos.orderItem?.created_at).format('YYYY-MM-DD hh:mm:ss A')
              }}</span>
            </div>
            <div class="flex justify-content-between mb-1">
              <span class="left">Order Status</span>
              <span class="right capitalize">{{ pos.orderStatus }}</span>
            </div>
          </div>
          <div class="order-actions mt-4">
            <ButtonGroup>
              <Button
                label="Process"
                icon="pi pi-check"
                severity="warning"
                :disabled="pos.orderStatus === 'process'"
                @click.prevent="pos.updateOrderStatus('process')"
              />
              <Button
                label="Completed"
                icon="pi pi-trash"
                severity="info"
                @click.prevent="pos.updateOrderStatus('completed')"
              />
              <Button
                label="Cancel"
                icon="pi pi-times"
                severity="danger"
                @click.prevent="pos.cancel()"
              />
            </ButtonGroup>
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
    (acc, item) => acc + item?.subTotal,
    0
  )
  return result ? result.toFixed(2) : 0
})
</script>

<style lang="scss">
.tables {
  #order {
    background-color: #fff;
    position: relative;
  }

  .col-fixed {
    padding: 0 !important;
  }

  .order-header,
  .order-items,
  .order-footer {
    span {
      font-size: 0.9rem !important;
    }
  }

  .order-actions {
    text-align: center;

    button {
      font-size: 0.8rem;
    }
  }
}
</style>
