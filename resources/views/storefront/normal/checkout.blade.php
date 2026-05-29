@extends('layouts.storefront-normal')
@section('title', 'Checkout | Savile Row')
@section('content')
<main id="main-content" class="mx-auto max-w-5xl px-4 py-10 md:px-6 md:py-14">
    <a href="/cart" class="text-[13px] text-cl-muted hover:text-black">&larr; Back to bag</a>
    <h1 class="mt-6 font-serif text-3xl uppercase md:text-4xl">Checkout</h1>
    <div class="mt-10 grid gap-12 lg:grid-cols-2">
        <form class="space-y-8" data-paystack-checkout action="{{ route('checkout.paystack.initialize') }}">
            <div class="hidden border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-700" data-checkout-error></div>
            <section>
                <h2 class="text-xs uppercase tracking-[0.2em]">Market</h2>
                <select name="market" class="store-input mt-3"><option>United States / USD</option><option>United Kingdom / GBP</option><option>European Union / EUR</option><option>Ghana / GHS</option></select>
            </section>
            <section>
                <h2 class="text-xs uppercase tracking-[0.2em]">Delivery</h2>
                <div class="mt-3 space-y-3">
                    <input name="name" placeholder="Full name" class="store-input" required>
                    <input name="email" placeholder="Email address" type="email" class="store-input" required>
                    <input name="phone" placeholder="Phone number" class="store-input">
                    <input name="address" placeholder="Address" class="store-input" required>
                    <div class="grid grid-cols-2 gap-3"><input name="city" placeholder="City" class="store-input" required><input name="postal_code" placeholder="Postcode" class="store-input" required></div>
                </div>
            </section>
            <section>
                <h2 class="text-xs uppercase tracking-[0.2em]">Payment</h2>
                <label class="payment-card mt-3"><input type="radio" name="payment_method" value="paystack" checked> <span><strong>Paystack checkout</strong><small>Cards, bank transfer, mobile money, and supported Paystack channels.</small></span></label>
            </section>
            <textarea name="note" class="store-input min-h-28" placeholder="Delivery instructions or client services note."></textarea>
            <button type="submit" class="btn-red w-full py-4" data-paystack-submit>Pay securely with Paystack</button>
        </form>
        <aside class="border border-cl-gray-mid p-6 lg:self-start">
            <h2 class="font-serif text-xl">Order summary</h2>
            <ul data-checkout-list class="mt-4 space-y-2 text-sm"></ul>
            <dl class="mt-6 space-y-2 border-t border-cl-gray-mid pt-4 text-sm">
                <div class="flex justify-between"><dt>Subtotal</dt><dd data-cart-subtotal>$0</dd></div>
                <div class="flex justify-between"><dt>Shipping</dt><dd data-checkout-shipping>Complimentary</dd></div>
                <div class="flex justify-between text-cl-muted"><dt>Est. tax</dt><dd>At payment</dd></div>
                <div class="flex justify-between border-t border-cl-gray-mid pt-4 font-serif text-lg"><dt>Total</dt><dd data-checkout-total>$0</dd></div>
            </dl>
            <p class="mt-4 text-xs text-cl-muted">Orders are encrypted and reviewed before fulfillment.</p>
        </aside>
    </div>
</main>
@endsection
