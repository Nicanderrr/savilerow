@extends('layouts.app')
@section('title', $title.' | Savile Row')
@section('content')
@php
    $activeKey = $gender === 'all' ? 'all-products' : $gender.'-'.$category;
    $sort = request('sort', 'featured');
@endphp
<main id="main-content" class="bg-cl-white">
    <header class="collection-hero-lux">
        <div class="mx-auto grid max-w-[1600px] gap-8 md:grid-cols-[1fr_auto] md:items-end">
            <div>
                <p class="text-label text-white/60">{{ $eyebrow }}</p>
                <h1 class="mt-4 max-w-4xl font-serif text-5xl uppercase leading-[0.9] tracking-tight sm:text-6xl md:text-8xl">{{ $title }}</h1>
                <p class="mt-6 max-w-2xl text-sm leading-8 text-white/68">{{ count($products) }} pieces selected for sharp wardrobe building, travel, appointments, and evening wear.</p>
            </div>
            <div class="grid grid-cols-3 gap-2 md:w-[420px]">
                <div class="collection-stat"><p class="font-serif text-2xl">{{ count($products) }}</p><p class="text-[10px] uppercase tracking-widest text-white/55">Pieces</p></div>
                <div class="collection-stat"><p class="font-serif text-2xl">48h</p><p class="text-[10px] uppercase tracking-widest text-white/55">Dispatch</p></div>
                <div class="collection-stat"><p class="font-serif text-2xl">Free</p><p class="text-[10px] uppercase tracking-widest text-white/55">Returns</p></div>
            </div>
        </div>
    </header>

    <section class="sticky top-[var(--header-total)] z-20 border-b border-cl-gray-mid bg-white/90 backdrop-blur-xl">
        <div class="collection-toolbar mx-auto max-w-[1600px] px-4 py-4 sm:px-6 md:px-8">
            <button type="button" class="store-icon-btn lg:hidden" data-toggle="#filter-drawer" aria-label="Open filters">
                @include('partials.icon', ['name' => 'menu', 'class' => 'h-5 w-5'])
            </button>
            <form action="{{ url()->current() }}" class="collection-search">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input name="search" value="{{ request('search') }}" class="collection-search-input" placeholder="Search this collection">
                <button class="store-btn-dark">Search</button>
            </form>
            <form action="{{ url()->current() }}" class="collection-sort">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <label class="sr-only" for="sort">Sort products</label>
                <select id="sort" name="sort" class="store-select" onchange="this.form.submit()">
                    <option value="featured" @selected($sort === 'featured')>Featured</option>
                    <option value="newest" @selected($sort === 'newest')>Newest</option>
                    <option value="price-asc" @selected($sort === 'price-asc')>Price low to high</option>
                    <option value="price-desc" @selected($sort === 'price-desc')>Price high to low</option>
                </select>
            </form>
        </div>

        @if(request('search') || request('sort'))
            <div class="mx-auto flex max-w-[1600px] flex-wrap gap-2 px-4 pb-4 sm:px-6 md:px-8">
                @if(request('search'))
                    <span class="store-chip">Search: {{ request('search') }}</span>
                @endif
                @if($sort !== 'featured')
                    <span class="store-chip">Sort: {{ Str::headline($sort) }}</span>
                @endif
                <a href="{{ url()->current() }}" class="store-chip store-chip-link">Clear</a>
            </div>
        @endif
    </section>

    <div class="mx-auto grid max-w-[1600px] gap-8 px-4 py-10 sm:px-6 md:px-8 lg:grid-cols-[280px_1fr]">
        <aside class="hidden lg:block">
            <div class="collection-filter-panel">
                <p class="text-label">Refine</p>
                <nav class="mt-6 space-y-2 text-[13px]" aria-label="Collection filters">
                    @foreach($facets as $facet)
                        <a class="collection-filter-link {{ $activeKey === $facet['key'] ? 'is-active' : '' }}" href="{{ $facet['href'] }}">{{ $facet['label'] }}</a>
                    @endforeach
                </nav>
                <div class="mt-8 border-t border-cl-gray-mid pt-6">
                    <p class="text-label">Service</p>
                    <p class="mt-3 text-[12px] leading-relaxed text-cl-muted">Complimentary express delivery over $500, free returns, and private boutique pickup.</p>
                </div>
                <div class="mt-5 grid gap-3">
                    @foreach([['Client services','Fit advice before dispatch.'],['Boutique pickup','Reserve online, collect in Mayfair.']] as [$label, $copy])
                        <div class="store-service-card">
                            <p class="font-serif text-lg uppercase">{{ $label }}</p>
                            <p class="mt-2 text-xs leading-5 text-cl-muted">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>

        <section>
            <div class="mb-6 flex flex-col justify-between gap-3 border-b border-cl-gray-mid pb-5 sm:flex-row sm:items-end">
                <div>
                    <p class="text-label text-cl-muted">Catalog result</p>
                    <p class="mt-2 font-serif text-2xl uppercase">{{ count($products) }} products available</p>
                </div>
                <p class="max-w-sm text-xs leading-6 text-cl-muted">Every piece includes secure checkout, market-aware fulfillment, and support from our client services team.</p>
            </div>
            @if(count($products))
                <div class="product-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="store-empty-state">
                    <p class="font-serif text-3xl uppercase">No pieces found</p>
                    <p class="mt-3 text-sm text-cl-muted">Adjust your search or return to the full catalog.</p>
                    <a href="{{ route('collections.all') }}" class="btn-outline mt-8 inline-block">View all products</a>
                </div>
            @endif
        </section>
    </div>

    <aside id="filter-drawer" class="drawer fixed left-0 top-0 z-50 h-dvh w-[92vw] max-w-sm overflow-y-auto bg-white p-5 shadow-2xl lg:hidden">
        <div class="flex items-center justify-between">
            <p class="font-serif text-2xl uppercase">Refine</p>
            <button data-close="#filter-drawer" class="grid h-10 w-10 place-items-center" aria-label="Close filters">@include('partials.icon', ['name' => 'close', 'class' => 'h-6 w-6'])</button>
        </div>
        <nav class="mt-8 space-y-2" aria-label="Mobile collection filters">
            @foreach($facets as $facet)
                <a class="collection-filter-link {{ $activeKey === $facet['key'] ? 'is-active' : '' }}" href="{{ $facet['href'] }}">{{ $facet['label'] }}</a>
            @endforeach
        </nav>
    </aside>
</main>
@endsection
