@php($suggested = \App\Support\Catalog::featured(4))
<section class="border-t border-cl-gray-mid bg-cl-white px-4 py-10 sm:px-6 sm:py-12">
    <div class="mx-auto max-w-[1600px]">
        <div class="flex items-end justify-between gap-4"><h2 class="font-serif text-2xl uppercase">Suggested for you</h2><a href="/collections/all/products" class="text-label hover:underline">View all</a></div>
        <div class="mt-8 grid grid-cols-1 gap-y-8 min-[420px]:grid-cols-2 min-[420px]:gap-x-3 md:grid-cols-4 md:gap-x-6">
            @foreach($suggested as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>


