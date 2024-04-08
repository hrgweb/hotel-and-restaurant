<template>
  <div class="navbar text-white shadow-sm" style="width: 230px">
    <a href="#" class="px-4 pt-3 block text-lg font-bold">HRG</a>

    <ul class="pt-3">
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

<style scoped>
ul {
  li {
    a {
      i {
        @apply mr-2;
      }

      @apply p-2 block px-6;

      &:hover {
        @apply bg-gray-800;
      }
    }
  }
}
</style>
