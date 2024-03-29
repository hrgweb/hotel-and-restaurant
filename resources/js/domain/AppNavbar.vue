<template>
  <div class="navbar">
    <a
      href="#"
      class="text-gray-700 no-underline text-2xl font-bold text-center block py-4 bg-"
      >HRG</a
    >

    <ul>
      <li><i class="pi pi-home"></i> <a href="/dashboard">Dashboard</a></li>
      <li>
        <i class="pi pi-align-left"></i> <a href="/categories">Categories</a>
      </li>
      <li><i class="pi pi-palette"></i> <a href="/products">Products</a></li>
      <li><i class="pi pi-table"></i> <a href="/tables">Tables</a></li>
      <li>
        <i class="pi pi-user-plus"></i> <a href="/user-roles">User Roles</a>
      </li>
      <li><i class="pi pi-users"></i> <a href="/staffs">Staffs</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Taxes</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Units</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Coupon</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Menu Items</a></li>
      <li><i class="pi pi-check"></i> <a href="/">QR Code</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Order Management</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Stock Management</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Sales Report</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Drivers</a></li>
      <li><i class="pi pi-check"></i> <a href="/">Feedback</a></li>
    </ul>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped>
.navbar {
  a {
    color: #4b5563;
  }

  ul {
    padding: 0;
    margin: 0;

    & > li {
      list-style: none;
      display: flex;
      align-items: center;
      padding-left: 1.5rem;

      & > a {
        padding: 0.8rem;
        display: block;
        text-decoration: none;
      }
    }
  }
}
</style>
