<!doctype html>
<html lang="pt-BR" class="{{ request()->cookie('theme', 'dark') === 'light' ? 'light' : 'dark' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Autossencial')</title>
    <meta name="description" content="Autossencial — plano de saúde veicular. Manutenção, proteção e rastreamento do seu carro.">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    @yield('body')
    <script src="{{ asset('assets/js/lucide.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
