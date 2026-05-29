@extends('layouts.app')
@section('title', 'Bespoke Suit Configurator | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="collection-hero-lux">
        <div class="mx-auto max-w-5xl text-center">
            <p class="text-label text-white/60">Atelier</p>
            <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">Configure your suit</h1>
            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/65">Begin your commission online, then finalize cloth, fit, and measurements with our cutters.</p>
        </div>
    </section>
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-12 sm:px-6 md:px-8 lg:grid-cols-3">
        @foreach(['Cloth'=>['Navy Super 150s','Charcoal Barathea','Cream Linen'], 'Silhouette'=>['Two-piece','Dinner suit','Morning coat'], 'Details'=>['Peak lapel','Horn buttons','Working cuffs']] as $title => $items)
            <div class="store-luxury-surface p-5 sm:p-6">
                <p class="text-label text-cl-muted">Step {{ $loop->iteration }}</p>
                <h2 class="mt-2 font-serif text-3xl uppercase">{{ $title }}</h2>
                <div class="mt-6 space-y-3">
                    @foreach($items as $item)
                        <label class="payment-card cursor-pointer"><input type="radio" name="{{ $title }}"> <span><strong>{{ $item }}</strong><small>Recommended by the atelier</small></span></label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>
    <section class="border-y border-cl-gray-mid bg-[#f8f5ef] px-4 py-12 text-center sm:px-6 md:px-8">
        <p class="text-label text-cl-muted">Estimate</p>
        <p class="mt-3 font-serif text-4xl uppercase">From $4,200</p>
        <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-cl-muted">Final pricing depends on cloth, construction, and appointment requirements.</p>
        <a href="/appointments" class="btn-red mt-8 inline-block">Request fitting</a>
    </section>
</main>
@endsection
