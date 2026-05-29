@extends('layouts.storefront-normal')
@section('title', 'Boutique | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="mx-auto grid max-w-[1600px] gap-10 px-6 py-16 md:grid-cols-2 md:py-24">
        <div class="aspect-[4/5] overflow-hidden bg-cl-gray">
            <img src="/images/products/store.jpg" alt="Savile Row boutique" class="h-full w-full object-cover">
        </div>
        <div class="flex flex-col justify-center">
            <p class="text-label text-cl-muted">Mayfair, London</p>
            <h1 class="mt-4 font-serif text-4xl uppercase md:text-6xl">Visit our boutique</h1>
            <p class="mt-6 max-w-xl text-sm leading-8 text-cl-muted">Experience ready-to-wear, bespoke tailoring, leather goods, and private client services in person.</p>
            <div class="mt-8 border-y border-cl-gray-mid py-6 text-sm leading-8">
                <p>Monday - Saturday: 10:00 - 18:00</p>
                <p>Sunday: Private appointments only</p>
            </div>
            <a href="/appointments" class="btn-red mt-8 w-fit">Book appointment</a>
        </div>
    </section>
</main>
@endsection
