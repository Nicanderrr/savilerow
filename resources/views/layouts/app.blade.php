<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Savile Row - Official Website | Luxury tailoring & leather goods')</title>
    <meta name="description" content="Global luxury e-commerce for bespoke suits, ready-to-wear, shoes, bags, perfumes, and accessories. Mayfair since 1849.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col antialiased">
<a href="#main-content" class="skip-link">Skip to content</a>
@include('partials.header')
@yield('content')
@include('partials.suggested')
@include('partials.footer')
@include('partials.chrome')
</body>
</html>

