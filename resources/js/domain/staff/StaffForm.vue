<template>
  <div class="pb-3">
    <!-- Error -->
    <Message v-if="staff.errorMsg" severity="error" :closable="false">{{
      staff.errorMsg
    }}</Message>

    <form
      class="space-y-3"
      enctype="multipart/form-data"
      @submit.prevent="save"
    >
      <div class="flex space-x-3 items-center">
        <div class="flex flex-col w-6/12">
          <label for="first_name">Firstname</label>
          <InputText id="first_name" v-model="form.first_name" />
        </div>
        <div class="flex flex-col w-6/12">
          <label for="last_name">Lastname</label>
          <InputText id="last_name" v-model="form.last_name" />
        </div>
      </div>
      <div class="flex space-x-3 items-center">
        <div class="flex flex-col w-full">
          <label for="email">Email</label>
          <InputText id="email" v-model="form.email" />
        </div>
        <div class="flex flex-col w-full">
          <label for="username">Username</label>
          <InputText id="username" v-model="form.username" />
        </div>
      </div>
      <div class="flex space-x-3 items-center justify-center">
        <div class="flex flex-col w-6/12">
          <label for="dob">User Role</label>
          <Dropdown
            v-model="staff.selectedRole"
            :options="staff.roles"
            optionLabel="role"
            placeholder="Select a user role"
            class="w-full"
          />
        </div>
        <div class="flex space-x-3 w-6/12 relative top-2">
          <div class="flex flex-row items-center">
            <RadioButton v-model="form.gender" name="gender" value="male" />
            <label for="ingredient1" class="ml-2">Male</label>
          </div>
          <div class="flex flex-row items-center">
            <RadioButton v-model="form.gender" name="gender" value="female" />
            <label for="ingredient2" class="ml-2">Female</label>
          </div>
        </div>
      </div>

      <div class="flex flex-row space-x-2" style="margin-top: 20px">
        <Button
          v-if="!staff.isEdit"
          label="Save"
          type="submit"
          :loading="staff.loading"
          class="w-20"
        />
        <Button
          v-else
          label="Update"
          class="w-20"
          type="button"
          severity="info"
          :loading="staff.loading"
          @click.prevent="update"
        />
        <Button
          label="Cancel"
          class="w-20"
          type="button"
          severity="secondary"
          @click.prevent="staff.close()"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useStaffStore } from '@/domain/staff/store'

const staff = useStaffStore()

const form = computed(() => (!staff.isEdit ? staff.form : staff.editForm))

function save() {
  staff.save()
}

function update() {
  staff.update()
}
</script>
