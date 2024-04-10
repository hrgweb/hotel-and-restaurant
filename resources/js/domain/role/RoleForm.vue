<template>
  <div class="pb-3">
    <!-- Error -->
    <Message v-if="role.errorMsg" severity="error" :closable="false">{{
      role.errorMsg
    }}</Message>

    <form @submit.prevent="save">
      <div class="flex flex-col">
        <label for="role">Role</label>
        <InputText id="role" v-model="form.role" />
      </div>
      <div class="flex flex-row space-x-2" style="margin-top: 20px">
        <Button
          v-if="!role.isEdit"
          label="Save"
          class="w-20"
          type="submit"
          :loading="role.loading"
        />
        <Button
          v-else
          label="Update"
          class="w-20"
          type="button"
          severity="info"
          :loading="role.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          class="w-20"
          type="button"
          severity="secondary"
          @click.prevent="role.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useRoleStore } from '@/domain/role/store'

const role = useRoleStore()

const form = computed(() => (!role.isEdit ? role.form : role.editForm))

function save() {
  role.save()
}

function update() {
  role.update()
}
</script>
