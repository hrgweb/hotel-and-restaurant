<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            min-height: 100vh;
            color: #161c2d;
        }
    </style>

    @vite(['resources/css/app.scss', 'resources/ts/app.ts'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div id="app">
        <div class="header">
            <a href="/dashboard" style="text-decoration: none; font-size: 24px; font-weight: bold">hrgweb</a>
        </div>

        <div class="body grid">
            <nav class="col-fixed" style="width: 300px">
                <div><a href="/dashboard">Dashboard</a></div>
                <div><a href="/categories">Categories</a></div>
                <div><a href="/">Taxes</a></div>
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

            <main class="col p-3">
                <h2 class="p-0 mt-2">@yield('body-title', 'Page Title')</h2>

                @yield('body')
            </main>
        </div>

        <div class="footer">
            footer
        </div>
    </div>
</body>

</html>
