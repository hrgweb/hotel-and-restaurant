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
      <div
        class="product flex flex-wrap"
        style="height: 580px; overflow-y: scroll"
      >
        <template v-for="product in listOfProducts">
          <Card
            class="mr-3 mb-3"
            style="width: 13rem; cursor: pointer"
            @click="pos.addOrder(product)"
          >
            <template #header>
              <img
                alt="user header"
                class="w-full border-round-sm"
                style="height: 110px"
                :src="useImageSrc(product.thumbnail)"
              />
            </template>
            <template #title
              ><span class="text-sm block text-center capitalize">{{
                product?.name
              }}</span></template
            >
          </Card>
        </template>
      </div>
    </div>

    <!-- view orders -->
    <div class="col-fixed" id="view-order">
      <div
        class="view-order"
        style="width: 400px; height: 600px; background-color: #fff"
      >
        <DataTable :value="pos.orders" scrollable scrollHeight="500px">
          <template #empty>No orders</template>
          <Column
            field="product.name"
            class="text-sm"
            header="Product Name"
          ></Column>
          <Column field="product.price" header="Price" />
          <Column header="Qty" class="text-sm custom-col">
            <template #body="{ data, index }">
              <InputNumber
                v-model="data.qty"
                showButtons
                buttonLayout="horizontal"
                style="width: 100%"
                :min="0"
                :max="99"
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
              @click.prevent="pos.order()"
            />
            <Button
              label="Cancel"
              severity="danger"
              @click.prevent="pos.cancelOrder()"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { useImageSrc } from '@/composables/useImageSrc'
import { computed } from 'vue'

const pos = usePosStore()

const total = computed(() => pos.totalCost())

const listOfProducts = computed(() =>
  !pos.hasFilteredByCategory ? pos.products : pos.filteredProductsByCategory
)

const updatedQty = (data: any, index: number, e: any) => {
  const adjustedQty = e.value
  pos.orders[index].qty = adjustedQty
  pos.orders[index].subTotal = data.product.price * adjustedQty
}
</script>

<style lang="scss">
.table-order {
  button {
    text-transform: capitalize;
  }

  #view-order.col-fixed {
    padding: 0 !important;
  }

  .view-order {
    .custom-col {
      width: 150px;
      font-size: 0.9rem;
    }

    .p-inputnumber-input {
      width: 50px;
      text-align: center;
    }

    .footer {
      button {
        width: 100%;
      }

      .total {
        span {
          font-weight: bold;
          text-transform: uppercase;
        }
      }
    }
  }

  .product {
    .p-card-header {
      padding: 1.5rem;
    }

    .p-card-body {
      padding: 0 !important;
    }
  }
}
</style>
