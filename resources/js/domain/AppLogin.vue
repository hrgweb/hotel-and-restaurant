<template>
  <div
    class="login m-auto w-24rem surface-700 text-white p-4 border-round-md"
    style="margin-top: 150px !important"
  >
    <form method="POST" @submit.prevent="signin">
      <div class="flex flex-column gap-2">
        <label for="username">Username</label>
        <InputText id="username" v-model="form.username" />
      </div>

      <div class="flex flex-column gap-2 mt-2">
        <label for="password">Password</label>
        <InputText id="password" v-model="form.password" />
      </div>

      <div class="mt-4">
        <Button label="Sign In" type="submit" class="w-full" />
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import axios from 'axios'
import { reactive } from 'vue'

const form = reactive({
  username: '',
  password: '',
})

function signin() {
  axios
    .post('/signin')
    .then((data) => {
      console.log(data)
    })
    .catch((error: any) => {
      console.error(error)
    })
}
</script>

<style>
body {
  background-color: #f0f0f0;
}
</style>
