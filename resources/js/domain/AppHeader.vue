<template>
  <div
    class="header flex justify-content-between align-items-center mb-3 px-5 py-3"
  >
    <h2 class="text-base">{{ title }}</h2>

    <div class="flex align-items-center">
      <Button
        class="mr-3"
        icon="pi pi-desktop"
        severity="info"
        label="POS"
        size="small"
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
        <OverlayPanel ref="op">
          <div class="flex flex-column gap-3 w-25rem">
            <div>
              <span class="font-medium text-900 block mb-2"
                >Share this document</span
              >
            </div>
            <div>
              <span class="font-medium text-900 block mb-2">Invite Member</span>
            </div>
            <div>
              <span class="font-medium text-900 block mb-2">Team Members</span>
              <ul class="list-none p-0 m-0 flex flex-column gap-3">
                <li
                  v-for="member in members"
                  :key="member.name"
                  class="flex align-items-center gap-2"
                >
                  <img
                    :src="`https://primefaces.org/cdn/primevue/images/avatar/${member.image}`"
                    style="width: 32px"
                  />
                  <div>
                    <span class="font-medium">{{ member.name }}</span>
                    <div class="text-sm text-color-secondary">
                      {{ member.email }}
                    </div>
                  </div>
                  <div
                    class="flex align-items-center gap-2 text-color-secondary ml-auto text-sm"
                  >
                    <span>{{ member.role }}</span>
                    <i class="pi pi-angle-down"></i>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </OverlayPanel>
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
