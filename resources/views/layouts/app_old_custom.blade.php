<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>@yield('title')</title>
    <!-- 其他標頭資訊如 CSS 和 JavaScript 引用 -->
</head>

<body>
    <header>
        <!-- 可能的頁首內容 -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- 可能的頁尾內容 -->
    </footer>

    @stack('scripts')
</body>

</html>
