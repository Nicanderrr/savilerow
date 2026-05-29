@extends('layouts.app')
@section('title', $title.' | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="collection-hero-lux">
        <div class="mx-auto max-w-4xl text-center">
            <p class="text-label text-white/60">Paystack payment</p>
            <h1 class="mt-4 font-serif text-5xl uppercase leading-[0.9] md:text-7xl">{{ $title }}</h1>
            <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-white/65">{{ $message }}</p>
        </div>
    </section>
    <section class="mx-auto max-w-3xl px-4 py-12 text-center sm:px-6 md:px-8">
        @if($order)
            <div class="store-luxury-surface p-6">
                <p class="text-label text-cl-muted">Order</p>
                <p class="mt-3 font-serif text-3xl uppercase">{{ $order->order_number }}</p>
                <dl class="mx-auto mt-6 max-w-md space-y-3 text-sm">
                    <div class="flex justify-between"><dt>Status</dt><dd>{{ Str::headline($order->status) }}</dd></div>
                    <div class="flex justify-between"><dt>Payment</dt><dd>{{ Str::headline($order->payment_status) }}</dd></div>
                    <div class="flex justify-between border-t border-cl-gray-mid pt-3 font-serif text-xl"><dt>Total</dt><dd>{{ $order->currency }} {{ number_format($order->total, 2) }}</dd></div>
                </dl>
            </div>
        @endif
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="/collections/all/products" class="btn-outline">Continue shopping</a>
            <a href="/policies/faq" class="btn-red">Client services</a>
        </div>
    </section>
</main>
@if($status === 'success')
    <script>localStorage.removeItem('savile_cart');</script>
@endif
@endsection
