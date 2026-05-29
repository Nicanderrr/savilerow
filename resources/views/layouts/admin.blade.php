<!doctype html>
<html lang="en" class="admin-html">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Savile Row</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell" data-admin-shell>
<div class="admin-layout">
    @include('admin.partials.sidebar')
    <button type="button" class="admin-sidebar-overlay" data-admin-sidebar-overlay aria-label="Close admin menu"></button>
    <div class="admin-content">
        @include('admin.partials.navbar')
        <main class="admin-main">
            @if(session('success'))
                <div class="mb-6 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('status'))
                <div class="mb-6 rounded-[1.5rem] border border-sky-200 bg-sky-50 px-5 py-4 text-sm font-medium text-sky-800 shadow-sm">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-[1.5rem] border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-medium text-rose-800 shadow-sm">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
        <footer class="admin-footer">
            <p class="admin-footer-copy">
                COPYRIGHT {{ now()->year }} savile row. |
                <a href="{{ route('home') }}" class="admin-footer-link" target="_blank" rel="noreferrer">View storefront</a>
            </p>
        </footer>
    </div>
</div>
@stack('scripts')
</body>
</html>
