@php
    $cmsRoute = fn (string $section) => route('admin.cms.index', ['section' => $section]);
    $settingsRoute = fn (string $section) => route('admin.settings.index', ['section' => $section]);

    $navGroups = [
        [
            'label' => 'Overview',
            'icon' => 'overview',
            'links' => [
                ['label' => 'Dashboard', 'route' => route('admin.dashboard'), 'pattern' => 'admin.dashboard'],
                ['label' => 'Analytics', 'route' => route('admin.analytics.index'), 'pattern' => 'admin.analytics.*'],
            ],
        ],
        [
            'label' => 'Products',
            'icon' => 'products',
            'links' => [
                ['label' => 'All Products', 'route' => route('admin.products.index'), 'pattern' => 'admin.products.index'],
                ['label' => 'Add Product', 'route' => route('admin.products.create'), 'pattern' => 'admin.products.create'],
                ['label' => 'Categories', 'route' => route('admin.categories.index'), 'pattern' => 'admin.categories.*'],
                ['label' => 'Brands', 'route' => route('admin.brands.index'), 'pattern' => 'admin.brands.*'],
                ['label' => 'Inventory', 'route' => route('admin.inventory.index'), 'pattern' => 'admin.inventory.*'],
            ],
        ],
        [
            'label' => 'Orders',
            'icon' => 'orders',
            'links' => [
                ['label' => 'All Orders', 'route' => route('admin.orders.index'), 'pattern' => 'admin.orders.*'],
                ['label' => 'Returns', 'route' => route('admin.returns.index'), 'pattern' => 'admin.returns.*'],
                ['label' => 'Invoices', 'route' => route('admin.invoices.index'), 'pattern' => 'admin.invoices.*'],
            ],
        ],
        [
            'label' => 'Clients',
            'icon' => 'customers',
            'links' => [
                ['label' => 'Customers', 'route' => route('admin.customers.index'), 'pattern' => 'admin.customers.*'],
                ['label' => 'Staff & Roles', 'route' => route('admin.staff.index'), 'pattern' => 'admin.staff.*'],
            ],
        ],
        [
            'label' => 'Marketing',
            'icon' => 'marketing',
            'links' => [
                ['label' => 'Coupons & Promotions', 'route' => route('admin.promotions.index'), 'pattern' => 'admin.promotions.*'],
                ['label' => 'Homepage', 'route' => $cmsRoute('homepage'), 'pattern' => 'admin.cms.*', 'section' => 'homepage'],
                ['label' => 'Banners', 'route' => $cmsRoute('banners'), 'pattern' => 'admin.cms.*', 'section' => 'banners'],
                ['label' => 'Blog', 'route' => $cmsRoute('blog'), 'pattern' => 'admin.cms.*', 'section' => 'blog'],
                ['label' => 'Lookbook', 'route' => $cmsRoute('lookbook'), 'pattern' => 'admin.cms.*', 'section' => 'lookbook'],
            ],
        ],
        [
            'label' => 'Operations',
            'icon' => 'system',
            'links' => [
                ['label' => 'Reports', 'route' => route('admin.reports.index'), 'pattern' => 'admin.reports.*'],
                ['label' => 'General', 'route' => route('admin.settings.index'), 'pattern' => 'admin.settings.*', 'section' => null],
                ['label' => 'Payments', 'route' => $settingsRoute('payments'), 'pattern' => 'admin.settings.*', 'section' => 'payments'],
                ['label' => 'Shipping', 'route' => $settingsRoute('shipping'), 'pattern' => 'admin.settings.*', 'section' => 'shipping'],
                ['label' => 'Taxes', 'route' => $settingsRoute('taxes'), 'pattern' => 'admin.settings.*', 'section' => 'taxes'],
                ['label' => 'Localization', 'route' => $settingsRoute('localization'), 'pattern' => 'admin.settings.*', 'section' => 'localization'],
                ['label' => 'Themes', 'route' => $settingsRoute('themes'), 'pattern' => 'admin.settings.*', 'section' => 'themes'],
            ],
        ],
        [
            'label' => 'Account',
            'icon' => 'account',
            'links' => [
                ['label' => 'Profile', 'route' => route('admin.profile'), 'pattern' => 'admin.profile'],
                ['label' => 'View Store', 'route' => route('home'), 'pattern' => null, 'target' => '_blank'],
            ],
        ],
    ];

    $linkIsActive = function (array $link): bool {
        if (isset($link['section']) && request()->routeIs($link['pattern'] ?? '')) {
            return request()->route('section') === $link['section'];
        }

        return ! empty($link['pattern']) && request()->routeIs($link['pattern']);
    };

    $groupIsActive = fn (array $group): bool => collect($group['links'])->contains(fn ($link) => $linkIsActive($link));
@endphp

<aside class="admin-sidebar">
    <div class="admin-brand-card">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand-logo-shell">
            <span class="admin-brand-logo">SR</span>
            <span class="admin-brand-copy sidebar-label">
                <span class="admin-brand-name">Savile Row</span>
                <span class="admin-brand-tagline">Commerce control center</span>
            </span>
        </a>
        <div class="space-y-2 text-xs text-slate-300 sidebar-label">
            <p class="admin-role-line">Premium Commerce</p>
            <p class="mb-0 text-slate-400">Catalog, orders, customers, and storefront operations.</p>
        </div>
        <button data-sidebar-toggle class="admin-btn-secondary mt-4 hidden w-full lg:inline-flex" aria-label="Collapse sidebar">
            <span class="sidebar-label">Collapse Sidebar</span>
            <span class="sidebar-chevron"><<</span>
        </button>
    </div>

    <nav class="admin-sidebar-nav text-sm">
        @foreach ($navGroups as $group)
            @php($activeGroup = $groupIsActive($group))
            <details class="admin-nav-group" @if($activeGroup) open @endif>
                <summary class="admin-nav-group-summary">
                    <div class="admin-nav-group-meta">
                        <span class="admin-nav-group-symbol" aria-hidden="true">
                            @switch($group['icon'])
                                @case('products')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="m12 3 7 4v10l-7 4-7-4V7l7-4Z" stroke="currentColor" stroke-width="1.8"/><path d="M12 12 5.5 8.2M12 12l6.5-3.8M12 12v8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('orders')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M6.5 4h11L19 20H5L6.5 4Z" stroke="currentColor" stroke-width="1.8"/><path d="M9 8a3 3 0 0 0 6 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('customers')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('marketing')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 10h4l8-4v12l-8-4H4v-4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 14v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('system')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M5 6.75A1.75 1.75 0 0 1 6.75 5h10.5A1.75 1.75 0 0 1 19 6.75v10.5A1.75 1.75 0 0 1 17.25 19H6.75A1.75 1.75 0 0 1 5 17.25V6.75Z" stroke="currentColor" stroke-width="1.8"/><path d="M8.5 9h7M8.5 12h7M8.5 15h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @case('account')
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM5 19.5a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M5 12h5V5H5v7ZM14 19h5v-7h-5v7ZM14 10h5V5h-5v5ZM5 19h5v-5H5v5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                            @endswitch
                        </span>
                        <p class="admin-nav-group-title sidebar-label">{{ $group['label'] }}</p>
                        <span class="admin-nav-group-count">{{ count($group['links']) }}</span>
                    </div>
                    <svg class="admin-nav-group-icon sidebar-chevron" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </summary>

                <div class="admin-nav-group-links sidebar-label">
                    @foreach ($group['links'] as $link)
                        <a
                            href="{{ $link['route'] }}"
                            class="admin-nav-link {{ $linkIsActive($link) ? 'admin-nav-link-active' : '' }}"
                            @if(! empty($link['target'])) target="{{ $link['target'] }}" rel="noreferrer" @endif
                        >
                            <span>{{ $link['label'] }}</span>
                            @if(($link['badge'] ?? 0) > 0)
                                <span class="admin-badge-warning ms-auto">{{ $link['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </details>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10 p-4">
        @csrf
        <button class="admin-nav-link w-full" type="submit">Logout</button>
    </form>
</aside>
