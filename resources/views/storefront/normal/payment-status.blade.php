@extends('layouts.storefront-normal')
@section('title', $title.' | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="mx-auto max-w-4xl px-6 py-20 text-center">
        <p class="text-label text-cl-muted">Paystack payment</p>
        <h1 class="mt-4 font-serif text-4xl uppercase md:text-6xl">{{ $title }}</h1>
        <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-cl-muted">{{ $message }}</p>
        @if($order)
            <div class="mx-auto mt-10 max-w-md border border-cl-gray-mid p-6">
                <p class="text-label text-cl-muted">Order</p>
                <p class="mt-3 font-serif text-2xl uppercase">{{ $order->order_number }}</p>
                <dl class="mt-6 space-y-3 text-sm">
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
