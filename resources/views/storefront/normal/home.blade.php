@extends('layouts.storefront-normal')
@section('content')
<main id="main-content">
    <section class="normal-hero relative -mt-[var(--header-total)] h-[100svh] min-h-[640px] overflow-hidden bg-black pt-[var(--header-total)]">
        @if(($hero['media_type'] ?? 'video') === 'image')
            <img src="{{ $hero['image'] }}" alt="{{ $hero['title'] }}" class="absolute inset-0 h-full w-full object-cover">
        @else
            <video class="hero-video absolute inset-0 h-full w-full object-cover" autoplay loop muted playsinline preload="auto" poster="{{ $hero['image'] }}"><source src="{{ $hero['video'] }}" type="video/mp4"></video>
        @endif
        <div class="absolute inset-0 bg-black/35"></div>
        <div class="absolute inset-x-0 bottom-0 px-6 pb-12 text-center text-white md:pb-16">
            <p class="text-label">{{ $hero['eyebrow'] }}</p>
            <h1 class="mx-auto mt-4 max-w-4xl font-serif text-4xl uppercase leading-none md:text-7xl">{{ $hero['title'] }}</h1>
            <a href="{{ $hero['button_url'] }}" class="btn-ghost-white mt-8 inline-block">{{ $hero['button_label'] }}</a>
        </div>
    </section>

    <section class="px-6 py-16 md:px-10 md:py-24">
        <div class="mx-auto max-w-[1600px]">
            <div class="mb-10 text-center">
                <p class="text-label text-cl-muted">Discover</p>
                <h2 class="mt-3 font-serif text-3xl uppercase md:text-5xl">Shop the house</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                @forelse($collectionCards as $card)
                    <a href="{{ $card['href'] }}" class="normal-discover-card">
                        <img src="{{ $card['image'] ?: '/images/products/hero-poster.jpg' }}" alt="{{ $card['label'] }}">
                        <span>{{ $card['label'] }}</span>
                    </a>
                @empty
                    <div class="store-empty-state md:col-span-3">
                        <p class="font-serif text-3xl uppercase">No collections yet</p>
                        <p class="mt-3 text-sm text-cl-muted">Publish categories and products from the admin panel.</p>
                    </div>
                @endforelse
                <a href="/collections/all/products" class="normal-discover-card">
                    <img src="/images/products/hero-poster.jpg" alt="All products">
                    <span>All products</span>
                </a>
            </div>
        </div>
    </section>

    <section class="border-y border-cl-gray-mid bg-cl-gray px-6 py-16 md:px-10 md:py-24">
        <div class="mx-auto max-w-[1600px]">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-label text-cl-muted">New arrivals</p>
                    <h2 class="mt-3 font-serif text-3xl uppercase md:text-5xl">Latest pieces</h2>
                </div>
                <a href="/collections/all/products" class="text-label hover:underline">View all</a>
            </div>
            @if(count($featured))
                <div class="grid grid-cols-2 gap-x-4 gap-y-10 lg:grid-cols-4 lg:gap-x-6">
                    @foreach(array_slice($featured, 0, 8) as $product)
                        @include('partials.normal.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="store-empty-state">
                    <p class="font-serif text-3xl uppercase">No products published</p>
                    <p class="mt-3 text-sm text-cl-muted">Add and publish products in the admin panel to populate this section.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="bg-cl-black px-6 py-20 text-white md:px-10 md:py-28">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-label opacity-80">The House</p>
            <h2 class="mt-4 font-serif text-3xl uppercase md:text-5xl">The world of Savile Row</h2>
            <p class="mt-6 text-[13px] leading-relaxed text-white/75">Seven generations of cutters and tailors on London&apos;s most famous street, brought online through a clean commerce experience.</p>
        </div>
    </section>
</main>
@endsection
