@extends('layouts.storefront-normal')
@section('title', $title.' | Savile Row')
@section('content')
@php
    $activeKey = $category === 'products' ? 'all-products' : 'all-'.$category;
    $sort = request('sort', 'featured');
@endphp
<main id="main-content" class="bg-white pb-20">
    <div class="mx-auto max-w-[1600px] px-6 pt-8">
        <a href="/" class="text-[13px] text-cl-muted hover:text-black">&larr; Back to home</a>
    </div>
    <header class="mx-auto max-w-[1600px] px-6 pb-6 pt-4 text-center md:pt-8">
        <p class="text-label text-cl-muted">{{ $eyebrow }}</p>
        <h1 class="mt-2 font-serif text-3xl uppercase md:text-5xl">{{ $title }}</h1>
        <p class="mx-auto mt-6 max-w-2xl text-[13px] leading-relaxed text-cl-muted">{{ count($products) }} pieces available from the current admin catalog.</p>
    </header>

    <section class="sticky top-[var(--header-total)] z-30 border-y border-cl-gray-mid bg-white">
        <div class="mx-auto flex max-w-[1600px] flex-wrap items-center justify-between gap-3 px-6 py-4">
            <button type="button" class="btn-outline px-5 py-2 lg:hidden" data-toggle="#normal-filter-drawer">Filter</button>
            <form action="{{ url()->current() }}" class="flex min-w-0 flex-1 gap-2 lg:max-w-md">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input name="search" value="{{ request('search') }}" class="store-input" placeholder="Search">
            </form>
            <form action="{{ url()->current() }}" class="w-full sm:w-56">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                <select name="sort" class="store-select" onchange="this.form.submit()">
                    <option value="featured" @selected($sort === 'featured')>Featured</option>
                    <option value="newest" @selected($sort === 'newest')>Newest</option>
                    <option value="price-asc" @selected($sort === 'price-asc')>Price low to high</option>
                    <option value="price-desc" @selected($sort === 'price-desc')>Price high to low</option>
                </select>
            </form>
        </div>
    </section>

    <div class="mx-auto grid max-w-[1600px] gap-8 px-4 py-10 md:px-6 lg:grid-cols-[240px_1fr]">
        <aside class="hidden lg:block">
            <div class="sticky top-[calc(var(--header-total)+5rem)]">
                <p class="text-label text-cl-muted">Collections</p>
                <nav class="mt-4 grid gap-1">
                    @foreach($facets as $facet)
                        <a class="normal-filter-link {{ $activeKey === $facet['key'] ? 'is-active' : '' }}" href="{{ $facet['href'] }}">{{ $facet['label'] }}</a>
                    @endforeach
                </nav>
            </div>
        </aside>

        <section>
            @if(count($products))
                <div class="grid grid-cols-2 gap-x-4 gap-y-12 lg:gap-x-6">
                    @foreach($products as $product)
                        @include('partials.normal.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="store-empty-state">
                    <p class="font-serif text-3xl uppercase">No pieces found</p>
                    <p class="mt-3 text-sm text-cl-muted">Adjust your search or publish products in this category.</p>
                    <a href="{{ route('collections.all') }}" class="btn-outline mt-8 inline-block">View all products</a>
                </div>
            @endif
        </section>
    </div>

    <aside id="normal-filter-drawer" class="drawer fixed left-0 top-0 z-50 h-dvh w-[92vw] max-w-sm overflow-y-auto bg-white p-6 shadow-2xl lg:hidden">
        <div class="flex items-center justify-between">
            <p class="font-serif text-2xl uppercase">Filter</p>
            <button data-close="#normal-filter-drawer" class="text-3xl leading-none" aria-label="Close filters">&times;</button>
        </div>
        <nav class="mt-8 grid gap-1">
            @foreach($facets as $facet)
                <a class="normal-filter-link {{ $activeKey === $facet['key'] ? 'is-active' : '' }}" href="{{ $facet['href'] }}">{{ $facet['label'] }}</a>
            @endforeach
        </nav>
    </aside>
</main>
@endsection
