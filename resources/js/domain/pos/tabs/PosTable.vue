<template>
  <div class="tables grid">
    <!-- list of table -->
    <div class="col">
      <div
        class="flex flex-wrap"
        style="height: 85vh; overflow-y: scroll; align-content: baseline"
      >
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
    <div
      class="col-fixed relative"
      id="order"
      style="width: 390px; height: 86vh"
    >
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
          <div
            v-if="pos.orderStatus !== OrderStatus.COMPLETED"
            class="order-actions mt-4"
          >
            <ButtonGroup>
              <Button
                label="Process"
                icon="pi pi-arrow-circle-up"
                severity="warning"
                :disabled="pos.orderStatus === OrderStatus.PROCESS"
                @click.prevent="
                  askToUpdateOrderStatus(OrderStatus.PROCESS, $event)
                "
              />
              <Button
                label="Completed"
                icon="pi pi-check"
                severity="info"
                @click.prevent="
                  askToUpdateOrderStatus(OrderStatus.COMPLETED, $event)
                "
              />
              <Button
                label="Cancel"
                icon="pi pi-times"
                severity="danger"
                :disabled="pos.orderStatus === OrderStatus.PENDING"
                @click.prevent="askToCancel"
              />
            </ButtonGroup>
          </div>

          <div
            v-if="pos.orderStatus === OrderStatus.COMPLETED"
            class="order-pay absolute"
            style="bottom: 0"
          >
            <Button
              label="Pay"
              class="w-full"
              severity="info"
              size="large"
              @click.prevent="pos.dialogPay()"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Pay dialog -->
    <Dialog
      v-model:visible="pos.showDialogPay"
      header="Pay"
      :style="{ width: '35rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="pos.closeDialogPayment()"
    >
      <!-- Error -->
      <Message
        v-if="pos.errorMsg"
        severity="error"
        class="p-0 m-0 mb-3"
        :closable="false"
        >{{ pos.errorMsg }}</Message
      >

      <!-- Amount -->
      <InputText
        type="text"
        v-model="pos.cashPayment"
        class="w-full"
        @keyup.enter="payment"
        @focus="focusPayment"
      />
    </Dialog>
  </div>
</template>

<script lang="ts" setup>
import PosTableItem from './../PosTableItem.vue'
import { usePosStore } from '@/domain/pos/store'
import { computed } from 'vue'
import dayjs from 'dayjs'
import { OrderStatus } from '@/enums/orderStatus'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'

const pos = usePosStore()
const confirm = useConfirm()
const toast = useToast()

const subTotal = computed(() => {
  let result = pos.viewPerTableOrders.reduce(
    (acc, item) => acc + item?.subTotal,
    0
  )
  pos.subTotal = result
  return result ? result.toFixed(2) : 0
})

function askToUpdateOrderStatus(status: string, event: any) {
  if (status === OrderStatus.PROCESS) {
    updateOrderStatus(status)
    return
  }

  confirm.require({
    target: event.currentTarget,
    message: `Are you sure you want to update the status to ${status.toLowerCase()}?`,
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => updateOrderStatus(status),
  })
}

const tableName = computed(() => pos.selectedTable?.table_name)

function updateOrderStatus(status: string) {
  pos
    .updateOrderStatus(status)
    .then(() => {
      toast.add({
        severity: 'info',
        summary: 'Info',
        detail: `${tableName.value} order is now ${status.toLowerCase()}`,
        life: 3000,
      })
    })
    .catch((error: any) => {
      console.error(error)
    })
}

function askToCancel(event) {
  confirm.require({
    target: event.currentTarget,
    message: 'Are you sure you want to cancel?',
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined p-button-sm',
    acceptClass: 'p-button-sm',
    rejectLabel: 'No',
    acceptLabel: 'Yes',
    accept: () => {
      pos
        .cancelProcessedOrder()
        .then(() => {
          toast.add({
            severity: 'info',
            summary: 'Info',
            detail: `${tableName.value} was put to pending`,
            life: 3000,
          })
        })
        .catch((error: any) => console.log(error))
    },
  })
}

function payment() {
  pos
    .payment()
    .then(() => {
      toast.add({
        severity: 'info',
        summary: 'Info',
        detail: `${tableName.value} successfully paid`,
        life: 3000,
      })
    })
    .catch((error: any) => {
      console.error(error)
      pos.errorMsg = error?.response?.data
    })
}

function focusPayment() {
  if (String(pos.cashPayment).length && parseFloat(pos.cashPayment) > 0) {
    return
  }

  pos.cashPayment = null
}
</script>

<style>
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

  .order-pay {
    background: silver;
    left: 0;
    right: 0;

    .p-button {
      border-radius: unset !important;
      height: 3rem;
      font-size: 1rem;
    }
  }
}
</style>
