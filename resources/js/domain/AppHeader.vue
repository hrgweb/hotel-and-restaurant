<template>
  <div class="header bg-white text-gray-700 flex justify-between p-3 shadow">
    <h2 class="text-base font-semibold tracking-wide">{{ title }}</h2>

    <div class="flex align-items-center">
      <Button
        class="mr-3"
        icon="pi pi-desktop"
        severity="info"
        label="POS"
        @click="gotoPos"
      />

      <div
        class="flex cursor-pointer relative"
        @click="toggleOverlay = !toggleOverlay"
      >
        <div class="text-xs capitalize text-right pr-3">
          <h4>{{ auth?.name }}</h4>
          <span>{{ auth?.staff?.staff_role?.role }}</span>
        </div>

        <Avatar label="P" class="shadow-sm" size="normal" shape="circle" />

        <!-- Overlay -->
        <div
          v-if="toggleOverlay"
          class="absolute w-60 bg-slate-50 rounded-lg top-12 p-6 right-0 shadow-lg z-50"
        >
          <div
            class="flex flex-col justify-center items-center"
            @click.stop="void"
          >
            <Avatar
              label="P"
              class="shadow-sm mb-4"
              size="large"
              shape="circle"
            />
            <h3 class="text-sm capitalize font-semibold">{{ auth?.name }}</h3>
            <span class="text-sm capitalize">{{
              auth?.staff?.staff_role?.role
            }}</span>
          </div>

          <ul class="mt-4">
            <li class="flex items-center">
              <InputIcon>
                <i class="pi pi-cog" />
              </InputIcon>
              <Button class="text-gray-700" label="Settings" link />
            </li>
            <li class="flex items-center">
              <InputIcon>
                <i class="pi pi-sign-out" />
              </InputIcon>
              <Button
                class="text-gray-700"
                label="Logout"
                link
                @click.prevent="logout"
              />
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

defineProps({
  title: String,
  auth: Object,
})

function gotoPos() {
  location.href = '/pos'
}

function logout() {
  axios
    .post('/logout')
    .then(() => (location.href = 'login'))
    .catch((error: any) => {
      console.error(error.response.data)
    })
}

const toggleOverlay = ref(false)
</script>
