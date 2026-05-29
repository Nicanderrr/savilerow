@extends('layouts.app')
@section('content')
<main id="main-content">
    <section class="relative -mt-[var(--header-total)] min-h-[720px] h-[100svh] w-full overflow-hidden bg-black pt-[var(--header-total)]">
        @if(($hero['media_type'] ?? 'video') === 'image')
            <img src="{{ $hero['image'] }}" alt="{{ $hero['title'] }}" class="absolute inset-0 h-full w-full object-cover">
        @else
            <video class="hero-video absolute inset-0 h-full w-full object-cover" autoplay loop muted playsinline preload="auto" poster="{{ $hero['image'] }}"><source src="{{ $hero['video'] }}" type="video/mp4"></video>
        @endif
        <div class="home-hero-shade absolute inset-0"></div>
        <div class="absolute inset-x-0 bottom-0 px-4 pb-8 text-white sm:px-6 md:px-10 md:pb-12">
            <div class="mx-auto grid max-w-[1600px] gap-6 lg:grid-cols-[1fr_420px] lg:items-end">
                <div>
                    <p class="text-label">{{ $hero['eyebrow'] }}</p>
                    <h1 class="mt-4 max-w-[11ch] font-serif text-5xl uppercase leading-[0.88] tracking-tight sm:text-6xl md:text-8xl">{{ $hero['title'] }}</h1>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ $hero['button_url'] }}" class="btn-ghost-white inline-block">{{ $hero['button_label'] }}</a>
                        <a href="/appointments" class="btn-ghost-white inline-block">Book fitting</a>
                    </div>
                </div>
                <div class="home-hero-panel hidden p-5 lg:block">
                    <p class="text-label text-white/70">House standard</p>
                    <p class="mt-4 font-serif text-2xl uppercase leading-tight">Ready-to-wear cut with the discipline of bespoke tailoring.</p>
                    <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                        <div><p class="font-serif text-2xl">7</p><p class="text-[10px] uppercase tracking-widest text-white/65">Generations</p></div>
                        <div><p class="font-serif text-2xl">48h</p><p class="text-[10px] uppercase tracking-widest text-white/65">Dispatch</p></div>
                        <div><p class="font-serif text-2xl">$500+</p><p class="text-[10px] uppercase tracking-widest text-white/65">Free ship</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="store-section bg-cl-white">
        <div class="store-section-head">
            <div>
                <p class="text-label text-cl-muted">Shop the house</p>
                <h2 class="store-section-title mt-3">Built for the appointment, the journey, and the evening.</h2>
            </div>
            <p class="store-subcopy max-w-md">A tighter commercial flow with editorial collections, clear entry points, and service promises visible before the customer reaches checkout.</p>
        </div>
        <div class="mx-auto grid max-w-[1600px] gap-4 md:grid-cols-2">
            @forelse($collectionCards as $card)
                <a href="{{ $card['href'] }}" class="home-collection-card">
                    <img src="{{ $card['image'] ?: '/images/products/hero-poster.jpg' }}" alt="{{ $card['label'] }}">
                    <div class="home-collection-card-content">
                        <p class="text-label text-white/75">{{ $card['count'] }} pieces</p>
                        <h3 class="mt-3 font-serif text-4xl uppercase leading-none md:text-5xl">{{ $card['label'] }}</h3>
                        <span class="mt-8 inline-block text-label underline-offset-4 group-hover:underline">Discover</span>
                    </div>
                </a>
            @empty
                <div class="store-empty-state md:col-span-2">
                    <p class="font-serif text-3xl uppercase">No collections yet</p>
                    <p class="mt-3 text-sm text-cl-muted">Publish products and categories from the admin panel to populate this section.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="store-section border-y border-cl-gray-mid bg-[#f8f5ef]">
        <div class="store-section-head">
            <div>
                <p class="text-label text-cl-muted">New arrivals</p>
                <h2 class="store-section-title mt-3">Pieces worth opening the wardrobe for.</h2>
            </div>
            <a href="/collections/all/products" class="btn-outline w-fit">View all</a>
        </div>
        <div class="mx-auto max-w-[1600px]">
            <div class="product-grid">
                @foreach(array_slice($featured, 0, 8) as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>

    <section class="grid bg-cl-black text-white lg:grid-cols-[.9fr_1.1fr]">
        <div class="flex flex-col justify-center px-5 py-16 sm:px-8 md:px-12 lg:px-16">
            <p class="text-label text-white/65">Concierge retail</p>
            <h2 class="mt-4 font-serif text-4xl uppercase leading-[0.95] md:text-6xl">Online commerce with boutique-level service.</h2>
            <p class="mt-6 max-w-xl text-sm leading-8 text-white/70">Private appointments, fit guidance, express fulfillment, and returns handled by client services instead of anonymous support queues.</p>
            <div class="mt-8 grid gap-3 sm:grid-cols-3">
                @foreach([['Private fittings','In-house and virtual appointments.'],['Secure checkout','Encrypted payment and manual review.'],['Free returns','Complimentary returns on eligible orders.']] as [$title, $copy])
                    <div class="border border-white/15 p-4">
                        <p class="font-serif text-xl uppercase">{{ $title }}</p>
                        <p class="mt-2 text-xs leading-5 text-white/60">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-2">
            @forelse($editorialCards as $card)
                <a href="{{ $card['href'] }}" class="store-editorial-card aspect-square">
                    <img src="{{ $card['image'] ?: '/images/products/hero-poster.jpg' }}" alt="{{ $card['label'] }}">
                    <div class="store-editorial-content">
                        <p class="font-serif text-xl uppercase leading-tight">{{ $card['label'] }}</p>
                    </div>
                </a>
            @empty
                <a href="/collections/all/products" class="store-editorial-card aspect-square">
                    <img src="/images/products/hero-poster.jpg" alt="All products">
                    <div class="store-editorial-content">
                        <p class="font-serif text-xl uppercase leading-tight">All products</p>
                    </div>
                </a>
            @endforelse
        </div>
    </section>
</main>
@endsection
