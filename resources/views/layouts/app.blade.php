<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Example') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/datatable_yajra.css', 'resources/js/app.js'])
</head>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<body>
    <div id="app">
        @include('layouts.navbar')
        <div class="row">
            @if (Auth::check() && Auth::user()->hasVerifiedEmail())
                @include('layouts.sidebarMenu')
            @endif

            @yield('content')
        </div>
    </div>
    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>

</html>
