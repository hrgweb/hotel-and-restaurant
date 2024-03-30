<template>
  <div class="header flex justify-content-between align-items-center mb-3 px-4">
    <h2>{{ title }}</h2>

    <span style="cursor: pointer" @click="gotoPos"
      ><span class="pi pi-desktop"></span> POS</span
    >

    <Button label="Logout" @click.prevent="logout" />
  </div>
</template>

<script setup lang="ts">
defineProps({
  title: String,
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
