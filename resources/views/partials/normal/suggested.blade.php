@php($suggested = \App\Support\Catalog::featured(4))
@if(count($suggested))
<section class="border-t border-cl-gray-mid bg-white px-4 py-10 sm:px-6 sm:py-12">
    <div class="mx-auto max-w-[1600px]">
        <div class="flex items-end justify-between gap-4">
            <h2 class="font-serif text-2xl uppercase">Suggested for you</h2>
            <a href="/collections/all/products" class="text-label hover:underline">View all</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-4 md:gap-x-6">
            @foreach($suggested as $product)
                @include('partials.normal.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif
