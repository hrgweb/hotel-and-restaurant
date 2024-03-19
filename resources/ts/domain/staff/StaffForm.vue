<template>
  <div>
    <!-- Error -->
    <Message v-if="staff.errorMsg" severity="error" :closable="false">{{
      staff.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <div class="flex flex-column gap-2">
        <label for="role">Role</label>
        <InputText id="role" v-model="form.role" />
      </div>
      <br />

      <div class="flex flex-column gap-2">
        <Button v-if="!staff.isEdit" label="Save" type="submit" />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          type="button"
          severity="secondary"
          @click.prevent="staff.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue'
import { useStaffStore } from '@/domain/staff/store/index'

const staff = useStaffStore()

const form = computed(() => (!staff.isEdit ? staff.form : staff.editForm))

function save() {
  staff.save()
}

function update() {
  staff.update()
}
</script>
