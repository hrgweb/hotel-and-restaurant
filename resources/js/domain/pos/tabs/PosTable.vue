<template>
  <div class="flex text-sm">
    <!-- list of table -->
    <div class="w-9/12">
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
    <div class="w-3/12 bg-white">
      <div
        v-if="pos.viewPerTableOrders && pos.viewPerTableOrders.length"
        class="p-3"
      >
        <div class="leading-3">
          <div class="space-x-2">
            <span class="left text-sm">Table No:</span>
            <span class="right text-sm font-semibold">{{
              pos?.selectedTable?.table_name
            }}</span>
          </div>
          <div class="space-x-2 pb-2" style="border-bottom: 2px dotted silver">
            <span class="left text-sm">Order Reference No:</span>
            <span class="right text-sm font-semibold">{{
              pos?.orderItem?.reference_no
            }}</span>
          </div>
        </div>
        <div class="order-items mt-3">
          <div v-for="orderItem in pos.viewPerTableOrders">
            <div class="flex justify-between">
              <span class="left">Item</span>
              <span>
                <span class="right capitalize pr-2">{{
                  orderItem?.product_name
                }}</span>
                <span>x{{ orderItem?.qty }}</span>
              </span>
            </div>
            <div
              class="flex justify-between mb-2"
              style="padding-bottom: 0.5rem; border-bottom: 1px solid silver"
            >
              <span class="left">Price</span>
              <span class="right">{{ orderItem?.price }}</span>
            </div>
          </div>
        </div>
        <div class="order-footer mt-3">
          <div class="space-x-2 flex justify-between">
            <span class="left">Subtotal</span>
            <span class="right font-semibold">{{ subTotal }}</span>
          </div>
          <div class="space-x-2 flex justify-between">
            <span class="left"> Created Time</span>
            <span class="right font-semibold">{{
              dayjs(pos.orderItem?.created_at).format('YYYY-MM-DD hh:mm:ss A')
            }}</span>
          </div>
          <div class="flex justify-between mb-1">
            <span class="left"> Status</span>
            <span class="right capitalize font-semibold">{{
              pos.orderStatus
            }}</span>
          </div>
        </div>
        <div
          v-if="pos.orderStatus !== OrderStatus.COMPLETED"
          class="order-actions mt-8"
        >
          <ButtonGroup class="space-x-2">
            <Button
              label="Process"
              class="text-xs"
              icon="pi pi-arrow-circle-up"
              severity="warning"
              :disabled="pos.orderStatus === OrderStatus.PROCESS"
              @click.prevent="
                askToUpdateOrderStatus(OrderStatus.PROCESS, $event)
              "
            />
            <Button
              label="Completed"
              class="text-xs"
              icon="pi pi-check"
              severity="info"
              @click.prevent="
                askToUpdateOrderStatus(OrderStatus.COMPLETED, $event)
              "
            />
            <Button
              label="Cancel"
              class="text-xs"
              icon="pi pi-times"
              severity="danger"
              :disabled="pos.orderStatus === OrderStatus.PENDING"
              @click.prevent="askToCancel"
            />
          </ButtonGroup>
        </div>

        <div v-if="pos.orderStatus === OrderStatus.COMPLETED" class="mt-8">
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

    <!-- Pay dialog -->
    <Dialog
      v-model:visible="pos.showDialogPay"
      header="Amount Received"
      :style="{ width: '22rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="pos.closeDialogPayment()"
    >
      <!-- Error -->
      <Message v-if="pos.errorMsg" severity="error" :closable="false">{{
        pos.errorMsg
      }}</Message>

      <!-- Amount -->
      <InputText
        type="text"
        v-model="pos.cashPayment"
        class="w-full mb-3"
        style="font-size: 1.5rem; font-weight: bold"
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
