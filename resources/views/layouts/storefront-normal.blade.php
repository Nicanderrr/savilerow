<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Savile Row - Official Website')</title>
    <meta name="description" content="Savile Row tailoring, ready-to-wear, shoes, bags, perfumes, and accessories.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="normal-storefront flex min-h-screen flex-col antialiased">
<a href="#main-content" class="skip-link">Skip to content</a>
@include('partials.normal.header')
@yield('content')
@include('partials.normal.suggested')
@include('partials.normal.footer')
@include('partials.normal.chrome')
</body>
</html>
