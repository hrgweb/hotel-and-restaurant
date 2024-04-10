<template>
  <div>
    <DataTable :value="pos.orderItems" scrollable scrollHeight="500px">
      <template #empty>No orders</template>
      <Column field="product_name" class="text-sm" header="Product Name">
      </Column>
      <Column field="price" header="Price" />
      <Column header="Qty" class="text-sm custom-col">
        <template #body="{ data, index }">
          <InputNumber
            v-model="data.qty"
            showButtons
            buttonLayout="horizontal"
            style="width: 100%"
            :min="1"
            :max="1000"
            @input="updatedQty(data, index, $event)"
          >
            <template #incrementbuttonicon>
              <span class="pi pi-plus" style="color: #059669" />
            </template>
            <template #decrementbuttonicon>
              <span class="pi pi-minus" style="color: #f87171" />
            </template>
          </InputNumber>
        </template>
      </Column>
    </DataTable>

    <div class="footer relative" style="margin-top: 0">
      <div
        class="total relative pt-2 px-3 flex justify-content-between align-items-center"
      >
        <span class="text-xl">Total</span>
        <span class="text-2xl">{{ total }}</span>
      </div>

      <div class="flex p-2">
        <Button
          label="Order"
          severity="info"
          class="mr-1"
          @click.prevent="pos.aboutToOrder()"
        />
        <Button
          label="Cancel"
          severity="danger"
          @click.prevent="pos.cancelOrder()"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { computed } from 'vue'

const pos = usePosStore()

const total = computed(() => pos.totalCost())

const updatedQty = (data: any, index: number, e: any) => {
  const adjustedQty = e.value
  pos.orderItems[index].qty = adjustedQty
  pos.orderItems[index].subtotal = data.product.price * adjustedQty
}
</script>
