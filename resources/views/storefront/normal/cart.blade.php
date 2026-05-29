@extends('layouts.storefront-normal')
@section('title', 'Shopping Bag | Savile Row')
@section('content')
<main id="main-content" class="mx-auto max-w-4xl px-6 py-12 md:py-16">
    <a href="/collections/all/products" class="text-[13px] text-cl-muted hover:text-black">&larr; Continue shopping</a>
    <h1 class="mt-6 font-serif text-3xl uppercase md:text-4xl">Shopping bag</h1>
    <p class="mt-2 text-[12px] text-cl-muted">Free returns. Secure checkout. Boutique-level service.</p>
    <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_320px]">
        <section>
            <ul data-cart-list class="divide-y divide-cl-gray-mid"></ul>
        </section>
        <aside class="border border-cl-gray-mid p-6 lg:self-start">
            <h2 class="font-serif text-xl">Order summary</h2>
            <p class="mt-4 flex justify-between font-serif text-xl"><span>Subtotal</span><span data-cart-subtotal>$0</span></p>
            <p class="mt-2 text-[12px] text-cl-muted">Tax calculated at checkout.</p>
            <a href="/checkout" class="btn-red mt-8 block w-full text-center">Proceed to checkout</a>
        </aside>
    </div>
</main>
@endsection
