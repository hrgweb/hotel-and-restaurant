<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>

    <style>
        /* html,
        body {
            padding: 0;
            margin: 0;
            min-height: 100vh;
            color: #161c2d;
        } */
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div id="app">
        @yield('body')
    </div>
</body>

</html>
