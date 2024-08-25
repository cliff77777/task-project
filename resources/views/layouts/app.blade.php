<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Example') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @include('layouts.navbar')
        <div class="row">
            @if (Auth::check() && Auth::user()->hasVerifiedEmail())
                @include('layouts.sidebarMenu')
            @endif
            @yield('content')
            @vite(['resources/js/app.js'])
            @stack('scripts')
        </div>
    </div>
</body>

</html>
