<template>
  <div class="bg-slate-50 rounded-lg shadow-sm p-6 m-6">
    <StaffFilter />
    <StaffDataTable />

    <Dialog
      v-model:visible="staff.showForm"
      :header="`${staff.isEdit ? ' Edit' : 'New'} Staff`"
      :style="{ width: '30rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="staff.close()"
    >
      <StaffForm />
    </Dialog>

    <Toast position="top-right" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import StaffForm from './StaffForm.vue'
import StaffFilter from './StaffFilter.vue'
import StaffDataTable from './StaffDataTable.vue'
import { useStaffStore } from '@/domain/staff/store/index'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
  roles: {
    type: [Array, Object],
    required: true,
  },
})

const staff = useStaffStore()

onMounted(() => {
  staff.data = props.data as any[]
  staff.roles = props.roles as any[]
})
</script>
