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
        }
    </style>

    @vite('resources/js/app.ts')
</head>

<body>
    <div id="app" class="flex">
        <div class="navbar col-fixed" style="width: 300px">
            <app-navbar />
        </div>

        <div class="body">
            <div class="header">
                <app-header />
            </div>

            <main class="p-3">
                <h2 class="p-0 mt-2">@yield('body-title', 'Page Title')</h2>

                @yield('body')
            </main>
        </div>
    </div>
</body>

</html>
