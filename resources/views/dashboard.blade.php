@section('title')
    Dashboard
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="header">
            <a href="/dashboard" style="text-decoration: none; font-size: 24px; font-weight: bold">hrgweb</a>
        </div>

        <div class="body grid">
            <nav class="col-fixed" style="width: 300px">
                <div><a href="/dashboard">Dashboard</a></div>
                <div><a href="/">Outlet Management</a></div>
                <div><a href="/">Taxes</a></div>
                <div><a href="/">Category</a></div>
                <div><a href="/">Units</a></div>
                <div><a href="/">Coupon</a></div>
                <div><a href="/">Menu Items</a></div>
                <div><a href="/">QR Code</a></div>
                <div><a href="/">Order Management</a></div>
                <div><a href="/">Stock Management</a></div>
                <div><a href="/">Sales Report</a></div>
                <div><a href="/">Drivers</a></div>
                <div><a href="/">Feedback</a></div>
            </nav>

            <main class="col">
                @yield('body')
            </main>
        </div>

        <div class="footer">
            footer
        </div>
    </div>
@endsection
