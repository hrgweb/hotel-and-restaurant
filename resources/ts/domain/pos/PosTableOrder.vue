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
      <PosTableOrderView />
    </div>

    <!-- order type -->
    <Dialog
      v-model:visible="pos.showAboutToOrder"
      header="Order Type"
      class="order-type"
      :style="{ width: '35rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="pos.close()"
    >
      <div class="actions">
        <Button
          label="Dine-In"
          severity="info"
          @click.prevent="pos.submitOrder('dinein')"
        />
        <Button
          label="Takeaway"
          severity="warning"
          @click.prevent="pos.submitOrder('takeaway')"
        />
        <Button
          label="Delivery"
          severity="help"
          @click.prevent="pos.submitOrder('delivery')"
        />
      </div>
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { useImageSrc } from '@/composables/useImageSrc'
import { computed } from 'vue'
import PosTableOrderView from './PosTableOrderView.vue'

const pos = usePosStore()

// const total = computed(() => pos.totalCost())

const listOfProducts = computed(() =>
  !pos.hasFilteredByCategory ? pos.products : pos.filteredProductsByCategory
)

// const updatedQty = (data: any, index: number, e: any) => {
//   const adjustedQty = e.value
//   pos.orderItems[index].qty = adjustedQty
//   pos.orderItems[index].subTotal = data.product.price * adjustedQty
// }
</script>

<style lang="scss">
.table-order {
  button {
    text-transform: capitalize;
  }

  #view-order.col-fixed {
    padding: 0 !important;
  }

  // .view-order {
  //   .custom-col {
  //     width: 150px;
  //     font-size: 0.9rem;
  //   }

  //   .p-inputnumber-input {
  //     width: 50px;
  //     text-align: center;
  //   }

  //   .footer {
  //     button {
  //       width: 100%;
  //     }

  //     .total {
  //       span {
  //         font-weight: bold;
  //         text-transform: uppercase;
  //       }
  //     }
  //   }
  // }

  .product {
    .p-card-header {
      padding: 1.5rem;
    }

    .p-card-body {
      padding: 0 !important;
    }
  }
}

.order-type {
  .actions {
    display: flex;

    button {
      height: 120px;
      flex: 1;
      margin-right: 0.3rem;

      &:last-child {
        margin-right: 0;
      }
    }
  }
}
</style>
