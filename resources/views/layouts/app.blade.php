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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>

<body>
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <div id="app">
        @include('layouts.navbar')
        <div class="row">
            @if (Auth::check() && Auth::user()->hasVerifiedEmail())
                @include('layouts.sidebarMenu')
            @endif
            @yield('content')
            <script src="{{ mix('js/app.js') }}"></script>
            @stack('scripts')
        </div>
    </div>
</body>

</html>
