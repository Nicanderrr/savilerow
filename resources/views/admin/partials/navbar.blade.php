@php
    $viewer = auth()->user();
    $viewerInitials = collect(explode(' ', $viewer->name ?? 'Admin'))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->join('');
    $unreadNotifications = \App\Models\AdminNotification::whereNull('read_at')->count();
    $unreadPaymentNotifications = \App\Models\AdminNotification::whereNull('read_at')->where('type', 'payment')->count();
    $unreadOtherNotifications = \App\Models\AdminNotification::whereNull('read_at')->where('type', '!=', 'payment')->count();
    $latestNotifications = \App\Models\AdminNotification::latest()->limit(5)->get();
@endphp

<header class="admin-topbar">
    <div class="flex flex-col gap-4 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
            <p class="admin-kicker">Premium Commerce Operations</p>
            <h1 class="mt-2 truncate text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">@yield('page-title', 'Dashboard')</h1>
            <p class="mt-2 truncate text-sm text-slate-500 dark:text-slate-400">@yield('page-description', 'Manage catalog, clients, orders, promotions, and reporting from one control center.')</p>
        </div>

        <div class="flex min-w-0 flex-wrap items-center gap-3 text-sm lg:flex-nowrap">
            <form action="{{ route('admin.products.index') }}" class="admin-navbar-search" data-admin-search-form>
                <button class="admin-icon-button" type="button" data-admin-search-toggle aria-label="Open search" title="Search">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m21 21-4.35-4.35M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
                <input data-admin-search name="search" class="admin-navbar-search-input" placeholder="Search products, orders, customers">
            </form>
            <button data-theme-toggle class="admin-icon-button" type="button" aria-label="Toggle color mode" title="Toggle color mode">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M21 12.8A8.5 8.5 0 1 1 11.2 3a6.7 6.7 0 0 0 9.8 9.8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
            </button>
            <details class="admin-notification-menu">
                <summary class="admin-icon-button" aria-label="Notifications" title="Notifications">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M10 21h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    @if($unreadOtherNotifications > 0)
                        <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-amber-400 ring-2 ring-white"></span>
                    @endif
                    @if($unreadPaymentNotifications > 0)
                        <span class="absolute -right-1 top-3 h-3 w-3 rounded-full bg-red-500 ring-2 ring-white"></span>
                    @endif
                </summary>
                <div class="admin-notification-dropdown">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-4 py-3">
                        <div>
                            <p class="mb-0 text-sm font-semibold text-slate-950">Notifications</p>
                            <p class="mb-0 text-xs text-slate-500">{{ $unreadNotifications }} unread alerts @if($unreadPaymentNotifications) · {{ $unreadPaymentNotifications }} payments @endif</p>
                        </div>
                        @if($unreadNotifications)
                            <form method="POST" action="{{ route('admin.notifications.clear') }}">
                                @csrf
                                <button class="admin-badge-warning border-0" type="submit">Clear all</button>
                            </form>
                        @else
                            <span class="admin-badge-warning">{{ $latestNotifications->count() }}</span>
                        @endif
                    </div>
                    <div class="max-h-80 overflow-y-auto p-2">
                        @forelse($latestNotifications as $notification)
                            <div class="admin-notification-item">
                                <span class="admin-notification-dot {{ $notification->type === 'payment' && ! $notification->read_at ? 'is-payment' : '' }} {{ $notification->read_at ? 'is-read' : '' }}"></span>
                                <span class="min-w-0">
                                    <a href="{{ $notification->url ?? '#' }}" class="block truncate text-sm font-semibold text-slate-900">{{ $notification->title }}</a>
                                    <span class="mt-1 line-clamp-2 block text-xs text-slate-500">{{ $notification->message }}</span>
                                    <span class="mt-2 flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        @unless($notification->read_at)
                                            <form method="POST" action="{{ route('admin.notifications.clear-one', $notification) }}">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 hover:text-slate-950">Clear</button>
                                            </form>
                                        @endunless
                                    </span>
                                </span>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-5 text-center text-sm text-slate-500">No notifications.</div>
                        @endforelse
                    </div>
                </div>
            </details>
            <span class="admin-user-chip">
                <span class="admin-user-chip-fallback">{{ $viewerInitials ?: 'A' }}</span>
                <span>{{ $viewer->name ?? 'Admin' }}</span>
            </span>
        </div>
    </div>
</header>
