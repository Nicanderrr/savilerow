@extends('layouts.app')
@section('title', 'Book an Appointment | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="grid min-h-[560px] bg-cl-black text-white lg:grid-cols-2">
        <div class="flex flex-col justify-center px-5 py-16 sm:px-8 md:px-12 lg:px-16">
            <p class="text-label text-white/60">Concierge</p>
            <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">Appointments</h1>
            <p class="mt-6 max-w-xl text-sm leading-8 text-white/70">Fittings, trunk shows, and virtual consultations with client advisors who understand cut, cloth, delivery, and occasion dressing.</p>
        </div>
        <div class="relative min-h-[420px]"><img src="/images/products/fitting.jpg" alt="Private fitting" class="absolute inset-0 h-full w-full object-cover"><div class="absolute inset-0 bg-black/20"></div></div>
    </section>
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:px-8 lg:grid-cols-[1fr_360px]">
        <form class="store-luxury-surface grid gap-4 p-5 sm:p-7 md:grid-cols-2">
            <div class="md:col-span-2"><p class="text-label text-cl-muted">Request a consultation</p><h2 class="mt-2 font-serif text-3xl uppercase">Tell us what you need</h2></div>
            <input class="store-input" placeholder="Full name">
            <input class="store-input" placeholder="Email" type="email">
            <select class="store-input"><option>Private fitting</option><option>Trunk show</option><option>Virtual consultation</option><option>Bespoke commission</option></select>
            <input class="store-input" type="date">
            <textarea class="store-input min-h-36 md:col-span-2" placeholder="Occasion, sizing notes, preferred pieces, or delivery timeline."></textarea>
            <button class="btn-red md:col-span-2" type="button">Request appointment</button>
        </form>
        <aside class="grid gap-4">
            @foreach([['Mayfair fitting','One-to-one appointment at the house.'],['Virtual consultation','Fit guidance before ordering.'],['Trunk show','Private regional appointments.']] as [$title,$copy])
                <div class="store-service-card"><p class="font-serif text-xl uppercase">{{ $title }}</p><p class="mt-2 text-sm leading-6 text-cl-muted">{{ $copy }}</p></div>
            @endforeach
        </aside>
    </section>
</main>
@endsection
