<article class="normal-product-card group relative">
    <a href="/products/{{ $product['slug'] }}" class="block">
        <div class="normal-product-media">
            <img src="{{ $product['images'][0] ?? '/images/products/hero-poster.jpg' }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]">
            @if($product['isNew'] ?? false)
                <span class="absolute left-3 top-3 bg-black px-2 py-0.5 text-[9px] uppercase tracking-widest text-white">New</span>
            @endif
        </div>
        <h3 class="mt-4 text-center font-serif text-base md:text-lg">{{ $product['name'] }}</h3>
        <p class="mx-auto mt-2 max-w-[220px] px-1 text-center text-[11px] leading-relaxed text-cl-muted">{{ Str::limit($product['description'], 90) }}</p>
        <p class="mt-2 text-center text-[13px]">
            <span class="text-cl-muted">As low as </span>
            <span class="font-semibold text-black">{{ \App\Support\Catalog::money($product['price']) }}</span>
        </p>
    </a>
</article>
