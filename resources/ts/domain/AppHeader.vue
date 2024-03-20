<template>
  <div class="flex justify-content-between align-items-center">
    <a
      href="/dashboard"
      style="text-decoration: none; font-size: 24px; font-weight: bold"
      >hrgweb</a
    >

    <span style="cursor: pointer" @click="gotoPos"
      ><span class="pi pi-desktop"></span> POS</span
    >
  </div>
</template>

<script setup lang="ts">
const gotoPos = () => {
  location.href = '/pos'
}
</script>
