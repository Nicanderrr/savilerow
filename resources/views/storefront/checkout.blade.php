@extends('layouts.app')
@section('title', 'Checkout | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="checkout-hero">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 md:px-8 md:py-16">
        <a href="/cart" class="text-label text-cl-muted hover:text-black">
            <span class="inline-flex items-center gap-2">@include('partials.icon', ['name' => 'arrow-left', 'class' => 'h-4 w-4']) Back to bag</span>
        </a>
        <header class="mt-6">
            <p class="text-label text-cl-muted">Private client checkout</p>
            <h1 class="mt-3 font-serif text-5xl uppercase leading-[0.95] md:text-7xl">Checkout</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-cl-muted">A clean checkout flow with market, delivery, payment, and order review grouped like a premium retail operation.</p>
        </header>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:py-12 md:px-8">
        <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_420px]">
            <form class="checkout-form" data-paystack-checkout action="{{ route('checkout.paystack.initialize') }}">
                <div class="hidden rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700" data-checkout-error></div>
                <section class="checkout-section">
                    <div class="checkout-section-head"><span>01</span><h2>Market</h2></div>
                    <select name="market" class="store-input"><option>United States / USD</option><option>United Kingdom / GBP</option><option>European Union / EUR</option><option>United Arab Emirates / AED</option><option>Australia / AUD</option></select>
                </section>

                <section class="checkout-section">
                    <div class="checkout-section-head"><span>02</span><h2>Delivery</h2></div>
                    <div class="grid gap-3">
                        <input name="name" placeholder="Full name" class="store-input" required>
                        <input name="email" placeholder="Email address" class="store-input" type="email" required>
                        <input name="phone" placeholder="Phone number" class="store-input">
                        <input name="address" placeholder="Address" class="store-input" required>
                        <div class="grid gap-3 sm:grid-cols-2"><input name="city" placeholder="City" class="store-input" required><input name="postal_code" placeholder="Postcode" class="store-input" required></div>
                    </div>
                </section>

                <section class="checkout-section">
                    <div class="checkout-section-head"><span>03</span><h2>Payment</h2></div>
                    <div class="grid gap-3">
                        <label class="payment-card"><input type="radio" name="payment_method" value="paystack" checked> <span><strong>Paystack checkout</strong><small>Cards, bank transfer, mobile money, and supported Paystack channels.</small></span></label>
                    </div>
                </section>

                <section class="checkout-section">
                    <div class="checkout-section-head"><span>04</span><h2>Concierge note</h2></div>
                    <textarea name="note" class="store-input min-h-32" placeholder="Sizing questions, delivery instructions, appointment requests, or gift notes."></textarea>
                </section>

                <button type="submit" class="btn-red w-full py-4" data-paystack-submit>Pay securely with Paystack</button>
            </form>

            <aside class="order-summary-card lg:sticky lg:top-32 lg:self-start">
                <p class="text-label text-cl-muted">Order summary</p>
                <ul data-checkout-list class="mt-5 space-y-3 text-sm"></ul>
                <dl class="mt-6 space-y-3 border-t border-cl-gray-mid pt-5 text-sm">
                    <div class="flex justify-between"><dt>Subtotal</dt><dd data-cart-subtotal>$0</dd></div>
                    <div class="flex justify-between"><dt>Shipping</dt><dd data-checkout-shipping>Complimentary</dd></div>
                    <div class="flex justify-between text-cl-muted"><dt>Est. tax</dt><dd>At payment</dd></div>
                    <div class="flex justify-between border-t border-cl-gray-mid pt-4 font-serif text-2xl"><dt>Total</dt><dd data-checkout-total>$0</dd></div>
                </dl>
                <p class="mt-5 text-xs leading-relaxed text-cl-muted">Duties may apply on orders over $800. Client services will contact you if additional verification is required.</p>
                <div class="mt-6 border-t border-cl-gray-mid pt-5">
                    <p class="text-label text-cl-muted">Checkout protection</p>
                    <div class="mt-4 grid gap-3">
                        <div class="store-service-card"><p class="font-serif text-lg uppercase">Encrypted payment</p><p class="mt-1 text-xs leading-5 text-cl-muted">Payment details are never stored in plain text.</p></div>
                        <div class="store-service-card"><p class="font-serif text-lg uppercase">Order review</p><p class="mt-1 text-xs leading-5 text-cl-muted">High-value orders are reviewed before dispatch.</p></div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
