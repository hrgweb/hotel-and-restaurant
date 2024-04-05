<template>
  <div class="header flex justify-content-between align-items-center mb-3 px-4">
    <h2>{{ title }}</h2>

    <span style="cursor: pointer" @click="gotoPos"
      ><span class="pi pi-desktop"></span> POS</span
    >

    <div>
      <Avatar label="P" class="mr-2" size="xlarge" shape="circle" />
      <div>
        <span>{{ auth?.name }}</span>
        <span>{{ auth?.staff?.staff_role?.role }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
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
</script>

<style>
.header + div {
  margin: 0 1.5rem;
}
</style>
