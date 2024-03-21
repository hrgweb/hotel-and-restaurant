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
      <div class="product flex flex-wrap">
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

    <!-- Items added to orders -->
    <div class="col-fixed" id="view-order">
      <div
        class="view-order"
        style="width: 400px; height: 100vh; background-color: #fff"
      >
        <DataTable :value="pos.orders">
          <Column
            field="product.name"
            class="text-sm"
            header="Product Name"
          ></Column>
          <Column header="Qty" class="text-sm custom-col">
            <template #body="{ data }">
              <!-- <Button label="Order" @click.prevent="pos.order()" /> -->
              <!-- <span>{{ data.qty }}</span> -->

              <InputNumber
                v-model="data.qty"
                showButtons
                buttonLayout="horizontal"
                style="width: 100%"
                :min="0"
                :max="99"
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

        <Button label="Order" @click.prevent="pos.order()" />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { usePosStore } from '@/domain/pos/store'
import { computed } from 'vue'
import { useImageSrc } from '@/composables/useImageSrc'

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

  .view-order {
    .custom-col {
      width: 150px;
      font-size: 0.9rem;
    }

    .p-inputnumber-input {
      width: 50px;
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
