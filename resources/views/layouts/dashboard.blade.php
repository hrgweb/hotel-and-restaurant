<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body class="bg-gray-700">
    <div id="app" class="flex flex-row">
        <app-navbar></app-navbar>

        <main class="flex-1 bg-slate-200">
            @yield('content')
        </main>
    </div>
</body>

</html>
