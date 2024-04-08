<template>
  <div class="header bg-sky-500 flex justify-between p-3 shadow-sm">
    <h2 class="text-base">{{ title }}</h2>

    <div class="flex align-items-center">
      <Button
        class="mr-3"
        icon="pi pi-desktop"
        severity="warning"
        label="POS"
        @click="gotoPos"
      />

      <div class="flex align-items-center cursor-pointer" @click="toggle">
        <Avatar label="P" class="mr-2" size="normal" shape="circle" />
        <div>
          <h4 class="m-0 text-sm capitalize">{{ auth?.name }}</h4>
          <span class="capitalize text-xs">{{
            auth?.staff?.staff_role?.role
          }}</span>
        </div>

        <!-- Overlay -->
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

const op = ref()
const members = ref([
  {
    name: 'Amy Elsner',
    image: 'amyelsner.png',
    email: 'amy@email.com',
    role: 'Owner',
  },
  {
    name: 'Bernardo Dominic',
    image: 'bernardodominic.png',
    email: 'bernardo@email.com',
    role: 'Editor',
  },
  {
    name: 'Ioni Bowcher',
    image: 'ionibowcher.png',
    email: 'ioni@email.com',
    role: 'Viewer',
  },
])

const toggle = (event) => {
  op.value.toggle(event)
}
</script>

<style>
.header + div {
  margin: 0 1.5rem;
}
</style>
