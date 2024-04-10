<template>
  <div class="login w-96 m-auto mt-40 shadow p-6 bg-slate-50 rounded-lg">
    <h2 class="text-3xl font-bold text-center pb-6">Sign In</h2>

    <form method="POST" @submit.prevent="signin">
      <!-- Error -->
      <Message v-if="hasError" severity="error" :closable="false">{{
        message
      }}</Message>

      <div class="flex flex-col mb-4">
        <label for="username">Username</label>
        <InputText id="username" v-model="form.username" />
      </div>

      <div class="flex flex-col mb-6">
        <label for="password">Password</label>
        <InputText id="password" type="password" v-model="form.password" />
      </div>

      <div class="mt-4">
        <Button label="Sign In" type="submit" class="w-full h-9" />
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'

defineProps({
  auth: Object,
})

const form = reactive({
  username: '',
  password: '',
})
const hasError = ref(false)
const message = ref('')

function signin() {
  hasError.value = false
  message.value = ''

  axios
    .post('/signin', form)
    .then(() => (location.href = '/dashboard'))
    .catch((error: any) => {
      console.error(error.response.data)
      hasError.value = true
      message.value = error?.response?.data?.message
      form.password = ''
      document.getElementById('password')?.focus()
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
