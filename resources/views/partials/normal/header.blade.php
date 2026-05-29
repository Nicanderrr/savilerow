<header class="normal-header sticky top-0 z-40">
    <div class="normal-promo">Complimentary express delivery and returns on orders over $500</div>
    <div class="normal-header-main">
        <div class="mx-auto flex h-[var(--header-main-h)] max-w-[1600px] items-center justify-between px-4 md:px-8">
            <div class="flex min-w-[90px] items-center md:min-w-[200px]">
                <button type="button" data-toggle="#normal-menu" class="flex items-center gap-3" aria-label="Menu">
                    @include('partials.icon', ['name' => 'menu', 'class' => 'h-6 w-6'])
                    <span class="hidden text-label md:inline">Menu</span>
                </button>
            </div>
            <a href="/" class="font-serif text-xl tracking-wide md:text-2xl" aria-label="Savile Row Home">Savile Row</a>
            <div class="flex min-w-[90px] items-center justify-end gap-3 md:min-w-[200px] md:gap-5">
                <button type="button" data-toggle="#search-overlay" aria-label="Search">@include('partials.icon', ['name' => 'search', 'class' => 'h-5 w-5'])</button>
                <a href="/market" aria-label="Market" class="hidden sm:block">@include('partials.icon', ['name' => 'account', 'class' => 'h-5 w-5'])</a>
                <a href="/collections/all/products" aria-label="Wishlist" class="hidden sm:block">@include('partials.icon', ['name' => 'heart', 'class' => 'h-5 w-5'])</a>
                <button type="button" data-toggle="#bag-drawer" class="relative" aria-label="Shopping bag">
                    @include('partials.icon', ['name' => 'bag', 'class' => 'h-5 w-5'])
                    <span data-cart-count class="absolute -right-2 -top-2 hidden h-4 min-w-4 rounded-full bg-cl-red px-1 text-center text-[9px] leading-4 text-white">0</span>
                </button>
            </div>
        </div>
    </div>

    <nav id="normal-menu" class="drawer normal-menu fixed left-0 top-0 z-50 flex h-dvh w-full max-w-[480px] flex-col bg-white shadow-2xl" aria-label="Main navigation">
        <div class="flex items-center justify-between px-6 py-5">
            <a href="/" class="font-serif text-xl">Savile Row</a>
            <button data-close="#normal-menu" class="text-3xl leading-none" aria-label="Close menu">&times;</button>
        </div>
        <div class="flex-1 overflow-y-auto px-6 pb-8">
            <ul>
                <li class="border-b border-cl-gray-mid/60"><a href="/" class="normal-menu-row">Home</a></li>
                <li class="border-b border-cl-gray-mid/60"><a href="/collections/all/products" class="normal-menu-row">All products</a></li>
                @foreach(array_slice($menuSidebar['facets'] ?? [], 0, 8) as $facet)
                    <li class="border-b border-cl-gray-mid/60"><a href="{{ $facet['href'] }}" class="normal-menu-row">{{ $facet['label'] }}</a></li>
                @endforeach
            </ul>
            <div class="mt-8">
                <p class="text-label text-cl-muted">House services</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="/boutique">Visit our boutique</a></li>
                    <li><a href="/appointments">Book an appointment</a></li>
                    <li><a href="/bespoke">Bespoke configurator</a></li>
                    <li><a href="/policies/faq">Contact us</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-cl-gray-mid px-6 py-6 text-sm">
            <a href="/market" class="text-cl-muted">United States / USD</a>
        </div>
    </nav>
</header>
