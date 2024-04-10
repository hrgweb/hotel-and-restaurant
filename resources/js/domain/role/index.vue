<template>
  <div class="bg-slate-50 rounded-lg shadow-sm p-6 m-6">
    <RoleFilter />
    <RoleDataTable />

    <Dialog
      v-model:visible="table.showForm"
      :header="`${table.isEdit ? ' Edit' : 'New'} Role`"
      :style="{ width: '30rem' }"
      :closeOnEscape="true"
      :draggable="false"
      modal
      @hide="table.close()"
    >
      <RoleForm />
    </Dialog>

    <Toast position="top-right" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import RoleForm from './RoleForm.vue'
import RoleFilter from './RoleFilter.vue'
import RoleDataTable from './RoleDataTable.vue'
import { useRoleStore } from '@/domain/role/store/index'

const props = defineProps({
  data: {
    type: [Array, Object],
    required: true,
  },
})

const table = useRoleStore()

onMounted(() => (table.data = props.data as any[]))
</script>
