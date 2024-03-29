<template>
  <div class="navbar">
    <a
      href="#"
      class="text-gray-700 no-underline text-2xl font-bold text-center block py-3 bg-"
      >HRG</a
    >

    <ul>
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/categories">Categories</a></li>
      <li><a href="/products">Products</a></li>
      <li><a href="/tables">Tables</a></li>
      <li><a href="/user-roles">User Roles</a></li>
      <li><a href="/staffs">Staffs</a></li>
      <li><a href="/">Taxes</a></li>
      <li><a href="/">Units</a></li>
      <li><a href="/">Coupon</a></li>
      <li><a href="/">Menu Items</a></li>
      <li><a href="/">QR Code</a></li>
      <li><a href="/">Order Management</a></li>
      <li><a href="/">Stock Management</a></li>
      <li><a href="/">Sales Report</a></li>
      <li><a href="/">Drivers</a></li>
      <li><a href="/">Feedback</a></li>
    </ul>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped>
.navbar {
  ul {
    padding: 0;
    margin: 0;

    & > li {
      list-style: none;

      & > a {
        padding: 0.8rem;
        display: block;
        text-decoration: none;
      }
    }
  }
}
</style>
