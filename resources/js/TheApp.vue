<template>
  <div>
    <slot />
  </div>
</template>

<script lang="ts" setup>
function submit() {
  alert('clicked')
}
</script>
