<template>
  <div
    class="login m-auto w-28rem surface-700 text-white p-4 border-round-md"
    style="margin-top: 150px !important"
  >
    <h2 class="m-0 pb-3">Sign In</h2>

    <form method="POST" @submit.prevent="signin">
      <!-- Error -->
      <Message v-if="hasError" severity="error" :closable="false">{{
        errorMsg
      }}</Message>

      <div class="flex flex-column gap-2">
        <label for="username">Username</label>
        <InputText id="username" v-model="form.username" />
      </div>

      <div class="flex flex-column gap-2 mt-2">
        <label for="password">Password</label>
        <InputText id="password" type="password" v-model="form.password" />
      </div>

      <div class="mt-4">
        <Button label="Sign In" type="submit" class="w-full" />
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import axios from 'axios'
import { reactive, ref } from 'vue'

defineProps({
  auth: Object,
})

const form = reactive({
  username: '',
  password: '',
})
const hasError = ref(false)
const errorMsg = ref('')

function signin() {
  hasError.value = false
  errorMsg.value = ''
  axios
    .post('/auth/signin', form)
    .then(() => (location.href = '/dashboard'))
    .catch((error: any) => {
      console.error(error.response.data)
      hasError.value = true
      errorMsg.value = error?.response?.data?.message
    })
}
</script>

<style>
body {
  background-color: #f0f0f0;
}

.login {
  .p-message-text {
    font-size: 0.8rem;
  }
}
</style>
