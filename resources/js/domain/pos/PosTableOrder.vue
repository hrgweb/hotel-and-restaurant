<template>
  <div class="flex space-x-4">
    <!-- Filter by categories -->
    <div class="w-2/12 space-y-2">
      <Button
        label="All Categories"
        severity="secondary"
        class="w-full uppercase tracking-wide shadow-md"
        style="height: 60px"
        raised
        @click.prevent="pos.onFilterByAllCategories()"
      />

      <template v-for="category in pos.categories">
        <Button
          :label="category?.name"
          severity="secondary"
          class="w-full uppercase tracking-wide shadow-md"
          style="height: 60px"
          raised
          @click.prevent="pos.onFilterByCategory(category)"
        />
      </template>
    </div>

    <!-- List of products -->
    <div class="w-7/12">
      <div
        class="product flex flex-wrap"
        style="height: 580px; overflow-y: scroll; align-content: baseline"
      >
        <template v-for="product in listOfProducts">
          <Card
            class="mr-3 mb-3"
            style="width: 13rem; height: 13rem; cursor: pointer"
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
    <div class="w-3/12" id="view-order">
      <div
        class="view-order"
        style="width: 400px; height: 600px; background-color: #fff"
      >
        <PosTableOrderView v-if="pos.orderItems && pos.orderItems.length" />
      </div>
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
      @hide="pos.closeOrder()"
    >
      <div class="actions">
        <Button
          label="Dine-In"
          severity="info"
          @click.prevent="pos.orderType = OrderType.DINEIN"
        />
        <Button
          label="Takeaway"
          severity="warning"
          @click.prevent="pos.orderType = OrderType.TAKEAWAY"
        />
        <Button
          label="Delivery"
          severity="help"
          @click.prevent="pos.orderType = OrderType.DELIVERY"
        />
      </div>

      <!-- place order -->
      <Button
        v-show="pos.orderType"
        label="Place Order"
        class="w-full mt-2"
        style="height: 60px"
        severity="success"
        @click.prevent="order"
      />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { useImageSrc } from '@/composables/useImageSrc'
import { computed } from 'vue'
import PosTableOrderView from './PosTableOrderView.vue'
import { useToast } from 'primevue/usetoast'
import { OrderType } from '@/enums/orderType'

const pos = usePosStore()
const toast = useToast()

const listOfProducts = computed(() =>
  !pos.hasFilteredByCategory ? pos.products : pos.filteredProductsByCategory
)

function order() {
  pos
    .submitOrder()
    .then((data) => {
      toast.add({
        severity: 'info',
        summary: 'Info',
        detail: 'Successfully added to orders',
        life: 3000,
      })
    })
    .catch((error: any) => {
      console.error(error)
    })
}
</script>
