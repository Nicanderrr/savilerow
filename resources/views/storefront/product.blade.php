@extends('layouts.app')
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
    <div class="mx-auto max-w-[1600px] px-4 py-6 sm:py-8 md:px-8 md:py-12">
        <a href="/collections/{{ $product['gender'] }}/{{ $product['category'] }}" class="text-label text-cl-muted hover:text-black">
            <span class="inline-flex items-center gap-2">@include('partials.icon', ['name' => 'arrow-left', 'class' => 'h-4 w-4']) Back to collection</span>
        </a>

        <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(400px,.85fr)] lg:gap-12">
            <section class="pdp-gallery">
                @foreach($product['images'] as $image)
                    <figure class="pdp-gallery-frame">
                        <img src="{{ $image }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover">
                    </figure>
                @endforeach
            </section>

            <aside class="pdp-panel">
                <p class="text-label text-cl-muted">{{ $product['categoryName'] ?? Str::headline($product['category']) }}</p>
                <h1 class="mt-3 font-serif text-4xl uppercase leading-[0.95] tracking-tight sm:text-5xl">{{ $product['name'] }}</h1>
                <p class="mt-5 font-serif text-2xl">{{ \App\Support\Catalog::money($product['price']) }}</p>
                <p class="mt-6 text-[13px] leading-relaxed text-cl-muted">{{ $product['description'] }}</p>

                <div class="mt-7 grid grid-cols-3 gap-2">
                    @foreach([['4.9','Client rating'],['48h','Dispatch'],['Free','Returns']] as [$value, $label])
                        <div class="pdp-stat-card">
                            <p class="font-serif text-2xl">{{ $value }}</p>
                            <p class="mt-1 text-[10px] uppercase tracking-widest text-cl-muted">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="pdp-purchase-card mt-8">
                    @if(count($product['colors']))
                        <fieldset>
                            <legend class="text-label">Color</legend>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($product['colors'] as $i => $color)
                                    <label class="cursor-pointer"><input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ $i === 0 ? 'checked' : '' }}><span class="option-pill peer-checked:border-black peer-checked:bg-black peer-checked:text-white">{{ $color }}</span></label>
                                @endforeach
                            </div>
                        </fieldset>
                    @endif

                    @if(count($product['sizes']))
                        <fieldset class="mt-6">
                            <div class="flex items-center justify-between gap-4"><legend class="text-label">Size</legend><button type="button" class="text-[11px] uppercase tracking-widest text-cl-muted hover:text-black">Size guide</button></div>
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
                            <label class="fulfillment-card"><input type="radio" name="fulfillment" value="In-store pickup"> <span><strong>Boutique pickup</strong><small>Collect from Savile Row after confirmation.</small></span></label>
                        </div>
                    </fieldset>

                    <div class="sticky bottom-0 z-20 -mx-5 mt-8 border-t border-cl-gray-mid bg-white p-4 sm:static sm:mx-0 sm:border-0 sm:p-0">
                        <button type="button" class="btn-red w-full py-4" data-add-product='@json($cartProduct)'>Add to bag</button>
                    </div>
                </div>

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

        <section class="mt-16 sm:mt-20">
            <div class="flex flex-col justify-between gap-4 border-t border-cl-gray-mid pt-10 sm:flex-row sm:items-end">
                <div><p class="text-label text-cl-muted">Complete the look</p><h2 class="mt-2 font-serif text-4xl uppercase leading-none">You may also like</h2></div>
                <a href="/collections/all/products" class="text-label hover:underline">View all</a>
            </div>
            <div class="product-grid mt-8">
                @foreach($related as $item)
                    @include('partials.product-card', ['product' => $item])
                @endforeach
            </div>
        </section>
    </div>
</main>
@endsection
