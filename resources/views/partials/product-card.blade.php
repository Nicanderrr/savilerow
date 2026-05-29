<a href="/products/{{ $product['slug'] }}" class="product-card group block">
    <div class="product-card-media">
        <img src="{{ $product['images'][0] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        @if($product['isNew'] ?? false)
            <span class="product-card-badge">New season</span>
        @endif
        <span class="product-card-wishlist" aria-hidden="true">@include('partials.icon', ['name' => 'heart', 'class' => 'h-4 w-4'])</span>
        <span class="product-card-action">View piece</span>
    </div>
    <div class="mt-4 flex items-start justify-between gap-4 px-1">
        <div class="min-w-0">
            <p class="product-card-title">{{ $product['name'] }}</p>
            <p class="product-card-meta">{{ $product['category'] }}</p>
            <p class="mt-2 hidden text-[12px] leading-5 text-cl-muted sm:block">{{ Str::limit($product['description'], 76) }}</p>
        </div>
        <p class="shrink-0 text-[12px] font-medium sm:text-[13px]">{{ \App\Support\Catalog::money($product['price']) }}</p>
    </div>
    <div class="mt-4 flex flex-wrap gap-2 px-1">
        @if($product['isBespokeEligible'] ?? false)
            <span class="store-chip">Bespoke eligible</span>
        @endif
        @if(! empty($product['material']))
            <span class="store-chip">{{ Str::of($product['material'])->before(',') }}</span>
        @endif
    </div>
</a>


