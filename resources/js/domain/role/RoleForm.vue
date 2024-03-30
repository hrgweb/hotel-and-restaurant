<template>
  <div>
    <!-- Error -->
    <Message v-if="role.errorMsg" severity="error" :closable="false">{{
      role.errorMsg
    }}</Message>

    <form @submit.prevent="save">
      <div class="flex flex-column gap-2">
        <label for="role">Role</label>
        <InputText id="role" v-model="form.role" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <Button
          v-if="!role.isEdit"
          label="Save"
          type="submit"
          :loading="role.loading"
        />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          :loading="role.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
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
