<template>
  <div class="navbar" style="">
    <a
      href="#"
      class="text-gray-700 no-underline text-2xl font-bold text-center block py-4 bg-"
      >HRG</a
    >

    <ul>
      <li>
        <a href="/dashboard"><i class="pi pi-home"></i>Dashboard</a>
      </li>
      <li>
        <a href="/categories"><i class="pi pi-align-left"></i>Categories</a>
      </li>
      <li>
        <a href="/products"><i class="pi pi-palette"></i>Products</a>
      </li>
      <li>
        <a href="/tables"><i class="pi pi-table"></i> Tables</a>
      </li>
      <li>
        <a href="/staffs"><i class="pi pi-users"></i>Staffs</a>
      </li>
      <li>
        <a href="/user-roles"><i class="pi pi-user-plus"></i>Staff Roles</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i> Taxes</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Units</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Coupon</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Menu Items</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>QR Code</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Order Management</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Stock Management</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Sales Report</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Drivers</a>
      </li>
      <li>
        <a href="/"><i class="pi pi-check"></i>Feedback</a>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts"></script>

<style scoped>
.navbar {
  box-shadow: rgb(223 223 223) 0px 4px 50px;
  width: 250px;

  a {
    color: #4b5563;
  }

  ul {
    padding: 0;
    margin: 0;

    & > li {
      & > a {
        padding: 0.8rem;
        display: block;
        text-decoration: none;
        transition: background-color 0.2s;

        &:hover {
          background-color: #334155;
          color: #fff;
        }

        & > i {
          padding-left: 1rem;
          padding-right: 0.6rem;
        }
      }
    }
  }
}
</style>
