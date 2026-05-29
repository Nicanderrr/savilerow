@extends('layouts.storefront-normal')
@section('title', $product['name'].' | Savile Row')
@section('content')
@php
    $cartProduct = [
        'slug' => $product['slug'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['images'][0] ?? null,
    ];
@endphp
<main id="main-content" class="bg-white">
    <div class="mx-auto max-w-[1600px] px-6 py-8">
        <a href="/collections/all/products" class="text-[13px] text-cl-muted hover:text-black">&larr; Back to products</a>
    </div>
    <div class="mx-auto grid max-w-[1600px] lg:grid-cols-2">
        <section class="grid gap-2 px-4 md:grid-cols-2 md:px-6">
            @foreach($product['images'] as $image)
                <figure class="aspect-[3/4] overflow-hidden bg-cl-gray">
                    <img src="{{ $image }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover">
                </figure>
            @endforeach
        </section>
        <aside class="px-6 pb-24 pt-8 lg:sticky lg:top-[var(--header-total)] lg:self-start lg:px-12 lg:pb-16">
            <p class="text-label text-cl-muted">{{ $product['categoryName'] ?? Str::headline($product['category']) }}</p>
            <h1 class="mt-3 font-serif text-3xl uppercase md:text-5xl">{{ $product['name'] }}</h1>
            <p class="mt-5 text-lg">{{ \App\Support\Catalog::money($product['price']) }}</p>
            <p class="mt-6 text-[13px] leading-relaxed text-cl-muted">{{ $product['description'] }}</p>

            @if(count($product['colors']))
                <fieldset class="mt-8">
                    <legend class="text-label">Colour</legend>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($product['colors'] as $i => $color)
                            <label class="cursor-pointer"><input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ $i === 0 ? 'checked' : '' }}><span class="option-pill peer-checked:border-black peer-checked:bg-black peer-checked:text-white">{{ $color }}</span></label>
                        @endforeach
                    </div>
                </fieldset>
            @endif

            @if(count($product['sizes']))
                <fieldset class="mt-6">
                    <legend class="text-label">Size</legend>
                    <div class="mt-3 grid grid-cols-4 gap-2 sm:grid-cols-5">
                        @foreach($product['sizes'] as $i => $size)
                            <label class="cursor-pointer"><input type="radio" name="size" value="{{ $size }}" class="peer sr-only" {{ $i === 0 ? 'checked' : '' }}><span class="option-pill justify-center peer-checked:border-black peer-checked:bg-black peer-checked:text-white">{{ $size }}</span></label>
                        @endforeach
                    </div>
                </fieldset>
            @endif

            <fieldset class="mt-6">
                <legend class="text-label">Fulfillment</legend>
                <div class="mt-3 grid gap-2">
                    <label class="fulfillment-card"><input type="radio" name="fulfillment" value="Ship to me" checked> <span><strong>Ship to me</strong><small>Express delivery and free returns over $500.</small></span></label>
                    <label class="fulfillment-card"><input type="radio" name="fulfillment" value="In-store pickup"> <span><strong>Boutique pickup</strong><small>Collect after confirmation.</small></span></label>
                </div>
            </fieldset>

            <button type="button" class="btn-red mt-8 w-full py-4" data-add-product='@json($cartProduct)'>Add to bag</button>

            <div class="mt-8 divide-y divide-cl-gray-mid border-y border-cl-gray-mid">
                @foreach(['Material' => $product['material'], 'Care' => $product['care'], 'Delivery & returns' => $product['shippingNote']] as $label => $value)
                    <details class="pdp-detail" @if($loop->first) open @endif>
                        <summary>{{ $label }}</summary>
                        <p>{{ $value }}</p>
                    </details>
                @endforeach
            </div>
        </aside>
    </div>
</main>
@endsection
