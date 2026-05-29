@extends('layouts.storefront-normal')
@section('title', 'FAQ | Savile Row')
@section('content')
<main id="main-content" class="mx-auto max-w-4xl px-6 py-16">
    <p class="text-label text-cl-muted">Client services</p>
    <h1 class="mt-4 font-serif text-4xl uppercase">Frequently asked questions</h1>
    <div class="mt-10 divide-y divide-cl-gray-mid border-y border-cl-gray-mid">
        @foreach([
            ['Orders','How do I track an order?','Client services will send order and payment updates after checkout.'],
            ['Fittings','Do you offer private fittings?','Yes. Book a Mayfair, trunk-show, or virtual consultation.'],
            ['Returns','Can I return an order?','Eligible ready-to-wear orders include complimentary returns. Bespoke and altered products may be final sale.'],
            ['Payments','Which payment methods are supported?','Paystack checkout supports cards, bank transfer, mobile money, and available regional channels.'],
        ] as [$topic, $question, $answer])
            <details class="pdp-detail">
                <summary>{{ $question }}</summary>
                <p><span class="text-label text-cl-muted">{{ $topic }}</span><br>{{ $answer }}</p>
            </details>
        @endforeach
    </div>
</main>
@endsection
