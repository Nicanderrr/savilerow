@extends('layouts.app')
@section('title', 'Market Selector | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="collection-hero-lux">
        <div class="mx-auto max-w-4xl text-center">
            <p class="text-label text-white/60">Global service</p>
            <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">Select your market</h1>
            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/65">Choose your preferred market for currency, fulfillment expectations, and localized checkout options.</p>
        </div>
    </section>
    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 md:px-8">
        <div class="store-luxury-surface grid gap-3 p-5 sm:p-7">
            @foreach(['United States / USD','United Kingdom / GBP','European Union / EUR','United Arab Emirates / AED','Australia / AUD'] as $market)
                <button class="flex items-center justify-between border border-cl-gray-mid bg-white p-4 text-left text-sm transition hover:border-black hover:bg-[#fbfaf7]">
                    <span>{{ $market }}</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
                </button>
            @endforeach
        </div>
    </section>
</main>
@endsection
