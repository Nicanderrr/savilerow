@extends('layouts.app')
@section('title', 'Visit Our Boutique | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="relative min-h-[620px] overflow-hidden bg-cl-black text-white">
        <img src="/images/products/store.jpg" alt="Savile Row boutique" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-black/45"></div>
        <div class="relative z-10 mx-auto flex min-h-[620px] max-w-[1600px] items-end px-5 pb-12 sm:px-8 md:px-12">
            <div class="max-w-3xl">
                <p class="text-label text-white/70">Mayfair, London</p>
                <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">Visit our boutique</h1>
                <p class="mt-6 max-w-xl text-sm leading-8 text-white/75">Experience tailoring, shoes, leather goods, and private fittings in our historic house on Savile Row.</p>
            </div>
        </div>
    </section>
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:px-8 lg:grid-cols-[1fr_360px]">
        <div class="store-luxury-surface p-6 sm:p-8">
            <p class="text-label text-cl-muted">House address</p>
            <address class="mt-5 not-italic">
                <p class="font-serif text-3xl uppercase">Savile Row</p>
                <p class="mt-4 text-sm leading-8 text-cl-muted">12 Savile Row<br>London W1S 3PR<br>United Kingdom</p>
                <p class="mt-4 text-sm"><a href="tel:+442073287000" class="hover:text-cl-red">+44 20 7328 7000</a></p>
            </address>
            <a href="/appointments" class="btn-red mt-8 inline-block">Book an appointment</a>
        </div>
        <aside class="grid gap-4">
            @foreach([['Opening hours','Monday to Saturday, private appointments available.'],['Services','Ready-to-wear, alterations, bespoke consultations, and pickup.'],['Client care','Contact the house before your visit to reserve specific pieces.']] as [$title,$copy])
                <div class="store-service-card"><p class="font-serif text-xl uppercase">{{ $title }}</p><p class="mt-2 text-sm leading-6 text-cl-muted">{{ $copy }}</p></div>
            @endforeach
        </aside>
    </section>
</main>
@endsection
