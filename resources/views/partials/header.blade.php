<header class="sticky top-0 z-40 {{ request()->is('/') ? 'header-home' : '' }}" data-site-header>
    <div class="h-[var(--header-promo-h)] truncate bg-black/90 px-3 text-center text-[9px] uppercase tracking-[0.16em] leading-[var(--header-promo-h)] text-white sm:text-[10px] sm:tracking-[0.25em]">Complimentary express delivery and returns on orders over $500</div>
    <div class="chrome-main transition-colors duration-300">
        <div class="mx-auto flex h-[var(--header-main-h)] max-w-[1600px] items-center justify-between px-3 sm:px-4 md:px-8">
            <div class="flex w-16 items-center sm:min-w-[100px] md:min-w-[200px]">
                <button type="button" data-toggle="#mobile-menu" class="flex items-center gap-3" aria-label="Menu">
                    @include('partials.icon', ['name' => 'menu', 'class' => 'h-6 w-6'])<span class="hidden text-label md:inline">Menu</span>
                </button>
            </div>
            <a href="/" class="font-serif text-lg tracking-wide sm:text-xl md:text-2xl" aria-label="Savile Row Home">Savile Row</a>
            <div class="flex w-20 items-center justify-end gap-2 text-[12px] sm:min-w-[100px] sm:gap-3 md:min-w-[200px] md:gap-5 md:text-sm">
                <button type="button" data-toggle="#search-overlay" aria-label="Search" class="grid h-9 w-9 place-items-center">@include('partials.icon', ['name' => 'search', 'class' => 'h-5 w-5'])</button>
                <a href="/market" aria-label="Market" class="hidden sm:grid h-9 w-9 place-items-center">@include('partials.icon', ['name' => 'account', 'class' => 'h-5 w-5'])</a>
                <a href="/collections/all/products" class="relative hidden h-9 w-9 place-items-center sm:grid" aria-label="Wishlist">@include('partials.icon', ['name' => 'heart', 'class' => 'h-5 w-5'])</a>
                <button type="button" data-toggle="#bag-drawer" class="relative grid h-9 w-9 place-items-center" aria-label="Shopping bag">@include('partials.icon', ['name' => 'bag', 'class' => 'h-5 w-5'])<span data-cart-count class="absolute -right-1 -top-1 hidden h-4 min-w-4 rounded-full bg-cl-red px-1 text-center text-[9px] leading-4 text-white">0</span></button>
            </div>
        </div>
    </div>
    <aside id="mobile-menu" class="drawer store-menu-drawer {{ ($menuSidebar['design'] ?? 'modern') === 'classic' ? 'store-menu-drawer-classic' : '' }} fixed left-0 top-0 z-50 h-dvh w-[94vw] max-w-[430px] overflow-y-auto p-5 shadow-2xl sm:p-6">
        @if(($menuSidebar['design'] ?? 'modern') === 'classic')
            <div class="flex items-start justify-between gap-4 border-b border-cl-gray-mid pb-5">
                <div>
                    <p class="text-label text-cl-muted">{{ $menuSidebar['eyebrow'] }}</p>
                    <p class="mt-2 font-serif text-3xl uppercase leading-none">{{ $menuSidebar['title'] }}</p>
                    <p class="mt-3 max-w-xs text-[13px] leading-6 text-cl-muted">{{ $menuSidebar['description'] }}</p>
                </div>
                <button data-close="#mobile-menu" class="store-menu-close-classic grid h-11 w-11 shrink-0 place-items-center rounded-full" aria-label="Close menu">@include('partials.icon', ['name' => 'close', 'class' => 'h-6 w-6'])</button>
            </div>

            <nav class="mt-7 grid gap-2" aria-label="Store navigation">
                <a href="/" class="store-menu-link-classic"><span>Home</span>@include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])</a>
                <a href="/collections/all/products" class="store-menu-link-classic"><span>All products</span>@include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])</a>
                @foreach(array_slice($menuSidebar['facets'] ?? [], 0, 8) as $facet)
                    <a href="{{ $facet['href'] }}" class="store-menu-link-classic"><span>{{ $facet['label'] }}</span><small>{{ $facet['count'] ?? 0 }}</small></a>
                @endforeach
            </nav>

            <div class="mt-8 grid gap-2 border-t border-cl-gray-mid pt-6">
                <p class="text-label text-cl-muted">Services</p>
                @foreach([
                    ['Bespoke configurator','/bespoke'],
                    ['Book appointment','/appointments'],
                    ['Visit boutique','/boutique'],
                    ['Client FAQ','/policies/faq'],
                ] as [$label, $href])
                    <a href="{{ $href }}" class="store-menu-link-classic"><span>{{ $label }}</span>@include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])</a>
                @endforeach
            </div>

            <a href="{{ $menuSidebar['cta_url'] }}" class="btn-red mt-8 block text-center">{{ $menuSidebar['cta_label'] }}</a>
        @else
            <div class="store-menu-hero" style="--store-menu-hero-image: url('{{ $menuSidebar['hero_image'] }}')">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-label text-white/60">{{ $menuSidebar['eyebrow'] }}</p>
                        <p class="mt-2 font-serif text-3xl uppercase leading-none">{{ $menuSidebar['title'] }}</p>
                    </div>
                    <button data-close="#mobile-menu" class="store-menu-close grid h-11 w-11 place-items-center rounded-full" aria-label="Close menu">@include('partials.icon', ['name' => 'close', 'class' => 'h-6 w-6'])</button>
                </div>
                <p class="mt-12 max-w-xs font-serif text-2xl uppercase leading-tight">{{ $menuSidebar['description'] }}</p>
                <a href="{{ $menuSidebar['cta_url'] }}" class="btn-ghost-white mt-6 inline-block">{{ $menuSidebar['cta_label'] }}</a>
            </div>

            <div class="mt-6">
                <p class="text-label text-cl-muted">Featured collections</p>
                <nav class="mt-4 grid gap-3" aria-label="Featured collections">
                    @foreach($menuSidebar['cards'] as $card)
                        <a href="{{ $card['url'] }}" class="store-menu-card">
                            <img src="{{ $card['image'] }}" alt="{{ $card['label'] }}">
                            <span class="store-menu-card-content">
                                <span class="block font-serif text-2xl uppercase leading-none">{{ $card['label'] }}</span>
                                <span class="mt-2 inline-flex items-center gap-2 text-[10px] uppercase tracking-[.22em] text-white/75">Discover @include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-3 w-3'])</span>
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="mt-6 grid gap-2">
                <p class="text-label text-cl-muted">Navigation</p>
                <a href="/" class="store-menu-link">
                    <span class="font-serif text-lg uppercase">Home</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
                </a>
                <a href="/collections/all/products" class="store-menu-link">
                    <span class="font-serif text-lg uppercase">All products</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
                </a>
            </div>

            <div class="mt-6 grid gap-2">
                <p class="text-label text-cl-muted">House services</p>
                @foreach([
                    ['Bespoke configurator','/bespoke'],
                    ['Book appointment','/appointments'],
                    ['Visit boutique','/boutique'],
                    ['Client FAQ','/policies/faq'],
                ] as [$label, $href])
                    <a href="{{ $href }}" class="store-menu-link">
                        <span class="font-serif text-lg uppercase">{{ $label }}</span>
                        @include('partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
                    </a>
                @endforeach
            </div>

            <div class="mt-6 grid gap-3 border-t border-cl-gray-mid pt-6">
                <p class="text-label text-cl-muted">Client services</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="store-menu-service">
                        <p class="font-serif text-lg uppercase">Free returns</p>
                        <p class="mt-1 text-[12px] leading-5 text-cl-muted">Eligible orders include complimentary returns.</p>
                    </div>
                    <div class="store-menu-service">
                        <p class="font-serif text-lg uppercase">48h dispatch</p>
                        <p class="mt-1 text-[12px] leading-5 text-cl-muted">Ready-to-wear ships quickly.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 text-[11px] uppercase tracking-widest text-cl-muted">
                    <a class="border border-cl-gray-mid bg-white px-3 py-2" href="/policies/shipping">Shipping</a>
                    <a class="border border-cl-gray-mid bg-white px-3 py-2" href="/policies/returns">Returns</a>
                    <a class="border border-cl-gray-mid bg-white px-3 py-2" href="/market">United States / USD</a>
                </div>
            </div>
        @endif
    </aside>
</header>
