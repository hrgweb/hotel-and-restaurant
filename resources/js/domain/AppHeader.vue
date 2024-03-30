<template>
  <div class="header flex justify-content-between align-items-center mb-3 px-4">
    <h2>{{ title }}</h2>

    <span style="cursor: pointer" @click="gotoPos"
      ><span class="pi pi-desktop"></span> POS</span
    >
  </div>
</template>

<script setup lang="ts">
defineProps({
  title: String,
})

const gotoPos = () => {
  location.href = '/pos'
}
</script>

<style>
.header + div {
  margin: 0 1.5rem;
}
</style>
