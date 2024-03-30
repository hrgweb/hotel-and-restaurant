<template>
  <div>
    <!-- Error -->
    <Message v-if="staff.errorMsg" severity="error" :closable="false">{{
      staff.errorMsg
    }}</Message>

    <form enctype="multipart/form-data" @submit.prevent="save">
      <div class="flex flex-column gap-2">
        <label for="first_name">Firstname</label>
        <InputText id="first_name" v-model="form.first_name" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="last_name">Lastname</label>
        <InputText id="last_name" v-model="form.last_name" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="email">Email</label>
        <InputText id="email" v-model="form.email" />
      </div>
      <br />
      <div class="flex flex-column gap-2">
        <label for="username">Username</label>
        <InputText id="username" v-model="form.username" />
      </div>
      <br />
      <div class="flex">
        <div class="flex align-items-center mr-3">
          <RadioButton v-model="form.gender" name="gender" value="male" />
          <label for="ingredient1" class="ml-2">Male</label>
        </div>
        <div class="flex align-items-center">
          <RadioButton v-model="form.gender" name="gender" value="female" />
          <label for="ingredient2" class="ml-2">Female</label>
        </div>
      </div>
      <br />

      <div class="flex flex-column gap-2">
        <label for="dob">Date of Birth</label>
        <Calendar v-model="form.dob" dateFormat="mm-dd-yy" />
      </div>
      <br />

      <div class="flex flex-column gap-2">
        <label for="dob">User Role</label>
        <Dropdown
          v-model="staff.selectedRole"
          :options="staff.roles"
          optionLabel="role"
          placeholder="Select a user role"
          class="w-full"
        />
      </div>
      <br />

      <div class="flex flex-column gap-2">
        <!-- Error -->
        <Message v-if="staff.errorMsg" severity="error" :closable="false">{{
          staff.errorMsg
        }}</Message>
      </div>

      <div class="flex flex-column gap-2">
        <Button
          v-if="!staff.isEdit"
          label="Save"
          type="submit"
          :loading="staff.loading"
        />
        <Button
          v-else
          label="Update"
          type="button"
          severity="info"
          :loading="staff.loading"
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
