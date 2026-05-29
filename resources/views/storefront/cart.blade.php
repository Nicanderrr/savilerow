@extends('layouts.app')
@section('title', 'Shopping Bag | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="cart-hero">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 md:px-8 md:py-16">
        <a href="/collections/all/products" class="text-label text-cl-muted hover:text-black">
            <span class="inline-flex items-center gap-2">@include('partials.icon', ['name' => 'arrow-left', 'class' => 'h-4 w-4']) Continue shopping</span>
        </a>
        <header class="mt-6">
            <p class="text-label text-cl-muted">Secure checkout</p>
            <h1 class="mt-3 font-serif text-5xl uppercase leading-[0.95] md:text-7xl">Shopping bag</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-cl-muted">Free returns, express delivery, boutique pickup, and encrypted checkout for every order.</p>
        </header>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-12 md:px-8">
        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_360px]">
            <section class="cart-panel">
                <ul data-cart-list></ul>
            </section>
            <aside class="order-summary-card">
                <p class="text-label text-cl-muted">Summary</p>
                <p class="mt-4 flex justify-between font-serif text-2xl"><span>Subtotal</span><span data-cart-subtotal>$0</span></p>
                <div class="mt-5 rounded-none border border-cl-gray-mid bg-[#fbfaf7] p-4">
                    <label class="text-label text-cl-muted">Promotion code</label>
                    <div class="mt-3 grid grid-cols-[1fr_auto] gap-2">
                        <input class="store-input" placeholder="SAVILE10">
                        <button class="store-btn-dark" type="button">Apply</button>
                    </div>
                </div>
                <dl class="mt-6 space-y-3 border-y border-cl-gray-mid py-5 text-sm">
                    <div class="flex justify-between"><dt>Shipping</dt><dd>Calculated at checkout</dd></div>
                    <div class="flex justify-between"><dt>Returns</dt><dd>Complimentary</dd></div>
                    <div class="flex justify-between text-cl-muted"><dt>Duties</dt><dd>Destination based</dd></div>
                </dl>
                <a href="/checkout" class="btn-red mt-6 block text-center">Proceed to checkout</a>
                <p class="mt-4 text-xs leading-relaxed text-cl-muted">Orders are encrypted and reviewed by our client services team before fulfillment.</p>
                <div class="mt-5 grid gap-3">
                    @foreach([['Secure payment','Card details are encrypted.'],['Concierge support','Fit and delivery help before dispatch.']] as [$title,$copy])
                        <div class="store-service-card">
                            <p class="font-serif text-lg uppercase">{{ $title }}</p>
                            <p class="mt-1 text-xs leading-5 text-cl-muted">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
