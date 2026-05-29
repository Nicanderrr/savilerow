<div id="search-overlay" class="modal-backdrop fixed inset-0 z-50 bg-black/60 p-4">
    <div class="mx-auto mt-16 max-w-2xl rounded-[2rem] bg-white p-5 shadow-2xl sm:mt-24 sm:p-6">
        <div class="flex items-center justify-between"><p class="font-serif text-2xl uppercase">Search</p><button data-close="#search-overlay" class="grid h-10 w-10 place-items-center" aria-label="Close search">@include('partials.icon', ['name' => 'close', 'class' => 'h-6 w-6'])</button></div>
        <form action="/collections/all/products" class="mt-6"><input name="search" autofocus class="w-full border-b border-black py-3 text-xl outline-none" placeholder="Search the collection"></form>
        <div class="mt-5 flex flex-wrap gap-2 text-[11px] uppercase tracking-widest">
            @forelse(array_slice($menuSidebar['facets'] ?? [], 0, 3) as $facet)
                <a class="border border-cl-gray-mid px-3 py-2" href="{{ $facet['href'] }}">{{ $facet['label'] }}</a>
            @empty
                <a class="border border-cl-gray-mid px-3 py-2" href="/collections/all/products">All products</a>
            @endforelse
        </div>
    </div>
</div>
<aside id="bag-drawer" class="bag-drawer fixed right-0 top-0 z-50 h-dvh w-full max-w-md overflow-y-auto bg-white p-5 shadow-2xl sm:w-[92vw] sm:p-6">
    <div class="flex items-center justify-between"><p class="font-serif text-2xl uppercase">Shopping bag</p><button data-close="#bag-drawer" class="grid h-10 w-10 place-items-center" aria-label="Close shopping bag">@include('partials.icon', ['name' => 'close', 'class' => 'h-6 w-6'])</button></div>
    <ul data-cart-list class="mt-6"></ul>
    <div class="mt-8 border-t border-cl-gray-mid pt-6"><p class="flex justify-between font-serif text-xl"><span>Subtotal</span><span data-cart-subtotal>$0</span></p><p class="mt-2 text-[12px] text-cl-muted">Tax calculated at checkout. Duties may apply on orders over $800.</p><a href="/checkout" class="btn-red mt-6 block text-center">Proceed to checkout</a></div>
</aside>
