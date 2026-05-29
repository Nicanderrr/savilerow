@extends('layouts.storefront-normal')
@section('title', 'Market | Savile Row')
@section('content')
<main id="main-content" class="mx-auto max-w-3xl px-6 py-20">
    <p class="text-label text-cl-muted">Market</p>
    <h1 class="mt-4 font-serif text-4xl uppercase md:text-6xl">Region and currency</h1>
    <p class="mt-6 text-sm leading-8 text-cl-muted">Choose the market used for delivery expectations and payment currency display.</p>
    <div class="mt-10 grid gap-3">
        @foreach(['United States / USD','United Kingdom / GBP','European Union / EUR','Ghana / GHS','United Arab Emirates / AED'] as $market)
            <button type="button" class="flex justify-between border border-cl-gray-mid px-4 py-4 text-left text-sm hover:border-black">
                <span>{{ $market }}</span>
                <span>&rarr;</span>
            </button>
        @endforeach
    </div>
</main>
@endsection
