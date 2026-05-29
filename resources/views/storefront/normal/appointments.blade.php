@extends('layouts.storefront-normal')
@section('title', 'Appointments | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="mx-auto grid max-w-[1600px] gap-10 px-6 py-16 md:grid-cols-2 md:py-24">
        <div>
            <p class="text-label text-cl-muted">Private service</p>
            <h1 class="mt-4 font-serif text-4xl uppercase md:text-6xl">Book an appointment</h1>
            <p class="mt-6 max-w-xl text-sm leading-8 text-cl-muted">Schedule a fitting, virtual consultation, or boutique visit with client services.</p>
        </div>
        <form class="border border-cl-gray-mid p-6">
            <div class="grid gap-3">
                <input class="store-input" placeholder="Full name">
                <input class="store-input" placeholder="Email address">
                <input class="store-input" placeholder="Preferred date">
                <select class="store-input"><option>Mayfair fitting</option><option>Virtual consultation</option><option>Trunk show</option></select>
                <textarea class="store-input min-h-28" placeholder="Notes"></textarea>
                <button type="button" class="btn-red">Request appointment</button>
            </div>
        </form>
    </section>
</main>
@endsection
