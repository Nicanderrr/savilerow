@extends('layouts.app')
@section('title', 'FAQ | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="collection-hero-lux">
        <div class="mx-auto max-w-5xl text-center">
            <p class="text-label text-white/60">Client services</p>
            <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">How can we help?</h1>
            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/65">Answers for fittings, delivery, returns, market pricing, and checkout support before you place an order.</p>
        </div>
    </section>
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:px-8 lg:grid-cols-[280px_1fr]">
        <aside class="store-luxury-surface h-fit p-5">
            <p class="text-label text-cl-muted">Popular topics</p>
            <div class="mt-5 grid gap-2">
                @foreach(['Fittings','Shipping','Returns','Payments','Bespoke'] as $topic)
                    <a href="#{{ Str::slug($topic) }}" class="collection-filter-link">{{ $topic }}</a>
                @endforeach
            </div>
            <a href="/appointments" class="btn-red mt-6 block text-center">Book appointment</a>
        </aside>
        <div class="divide-y divide-cl-gray-mid border-y border-cl-gray-mid">
            @foreach([
                ['Fittings','Do you offer private fittings?','Yes. Book a Mayfair, trunk-show, or virtual consultation. A client advisor can guide sizing before dispatch or prepare pieces before your visit.'],
                ['Shipping','How fast do orders ship?','Most ready-to-wear orders dispatch within 48 hours. Complimentary express delivery applies on eligible orders over $500.'],
                ['Returns','Can I return an order?','Eligible ready-to-wear orders include complimentary returns. Bespoke, altered, and personalized products may be final sale.'],
                ['Payments','Is payment live?','Checkout is prepared for gateway integration. Connect Stripe, Adyen, PayPal, or your preferred provider before accepting production payments.'],
                ['Bespoke','Can I start a bespoke commission online?','Yes. Use the bespoke configurator to outline your commission, then request a fitting with the atelier team.'],
            ] as [$topic, $question, $answer])
                <section id="{{ Str::slug($topic) }}" class="py-6">
                    <p class="text-label text-cl-muted">{{ $topic }}</p>
                    <h2 class="mt-2 font-serif text-2xl uppercase">{{ $question }}</h2>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-cl-muted">{{ $answer }}</p>
                </section>
            @endforeach
        </div>
    </section>
</main>
@endsection
