@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-description','A control-center view of revenue, orders, customer growth, inventory risk, and product performance.')
@section('content')
<div class="admin-metric-grid">
    @foreach([['Revenue','$'.number_format($stats['revenue'],0),'Total paid revenue','admin-badge-success'],['Orders',number_format($stats['orders']),'Across all markets','admin-badge-info'],['Customers',number_format($stats['customers']),'Active client profiles','admin-badge-warning'],['Products',number_format($stats['products']),'Catalog styles','admin-badge-muted']] as [$label,$value,$hint,$badge])
        <div class="admin-card p-5 transition hover:-translate-y-1">
            <div class="flex items-start justify-between gap-4">
                <p class="admin-kicker">{{ $label }}</p>
                <span class="{{ $badge }}">Live</span>
            </div>
            <p class="mb-1 mt-5 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $value }}</p>
            <p class="mb-0 text-sm text-slate-500 dark:text-slate-400">{{ $hint }}</p>
        </div>
    @endforeach
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_.6fr]">
    <section class="admin-chart-shell">
        <div class="admin-panel-heading gap-4">
            <div>
                <p class="admin-kicker text-slate-400">Sales Overview</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-white">{{ $chart['useDaily'] ? 'Daily sales' : 'Monthly revenue' }}</h2>
                <p class="mt-2 text-sm text-slate-400">{{ \Carbon\Carbon::parse($chart['start'])->format('M j, Y') }} - {{ \Carbon\Carbon::parse($chart['end'])->format('M j, Y') }}</p>
            </div>
            <form class="grid gap-2 sm:grid-cols-[120px_1fr_1fr_auto]">
                <select name="range" class="admin-select !rounded-xl !bg-white/10 !text-white">
                    @foreach(['7d' => '7 days', '30d' => '30 days', '90d' => '90 days', '12m' => '12 months'] as $value => $label)
                        <option value="{{ $value }}" @selected($chart['range'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <input type="date" name="start" value="{{ $chart['start'] }}" class="admin-input !rounded-xl !bg-white/10 !text-white">
                <input type="date" name="end" value="{{ $chart['end'] }}" class="admin-input !rounded-xl !bg-white/10 !text-white">
                <button class="admin-btn-secondary !rounded-xl">Apply</button>
            </form>
        </div>
        <div class="mt-6 grid gap-3 md:grid-cols-3">
            <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Range revenue</p>
                <p class="mt-2 font-serif text-3xl text-white">${{ number_format($chart['summary']['revenue'], 0) }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Paid orders</p>
                <p class="mt-2 font-serif text-3xl text-white">{{ number_format($chart['summary']['orders']) }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Average order</p>
                <p class="mt-2 font-serif text-3xl text-white">${{ number_format($chart['summary']['averageOrderValue'], 0) }}</p>
            </div>
        </div>
        <div class="admin-chart-frame mt-6">
            <canvas id="salesChart" class="admin-chart-canvas"></canvas>
        </div>
    </section>

    <section class="admin-card p-5">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Inventory Risk</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Low stock alerts</h2>
            </div>
            <span class="admin-badge-danger">{{ $lowStock->count() }} alerts</span>
        </div>
        <div class="mt-5 space-y-3">
            @forelse($lowStock as $variant)
                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50/80 p-3">
                    <div>
                        <p class="mb-0 text-sm font-semibold text-slate-900">{{ $variant->product?->name }}</p>
                        <p class="mb-0 text-xs text-slate-500">{{ $variant->sku }}</p>
                    </div>
                    <span class="admin-badge-danger">{{ $variant->stock }}</span>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-sm text-slate-500">No low stock alerts.</div>
            @endforelse
        </div>
    </section>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Fulfillment</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Recent orders</h2>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="admin-btn-secondary">View all</a>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show',$order) }}">{{ $order->order_number }}</a></td>
                            <td>{{ $order->customer?->name ?? 'Guest' }}</td>
                            <td><span class="admin-badge-info">{{ $order->status }}</span></td>
                            <td>${{ number_format($order->total,0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-card p-5">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Merchandising</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Top products</h2>
            </div>
            <a href="{{ route('admin.products.index') }}" class="admin-btn-secondary">Catalog</a>
        </div>
        <div class="mt-5 space-y-3">
            @foreach($topProducts as $product)
                <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3">
                    <img class="h-14 w-12 rounded-xl object-cover" src="{{ $product->images->first()->path ?? '/images/products/hero-poster.jpg' }}" alt="">
                    <div class="min-w-0 flex-1">
                        <p class="mb-0 truncate text-sm font-semibold text-slate-900">{{ $product->name }}</p>
                        <p class="mb-0 text-xs text-slate-500">{{ $product->variants_count }} variants</p>
                    </div>
                    <span class="font-semibold text-slate-900">${{ number_format($product->price,0) }}</span>
                </div>
            @endforeach
        </div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('salesChart');
    if (!el || !window.Chart) return;

    const ctx = el.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(56, 189, 248, .34)');
    gradient.addColorStop(1, 'rgba(56, 189, 248, 0)');

    new Chart(el, {
        data: {
            labels: @json($chart['labels']),
            datasets: [
                {
                    type: 'line',
                    label: 'Revenue',
                    data: @json($chart['revenue']),
                    borderColor: '#38bdf8',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: .42,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#f8fafc',
                    pointBorderColor: '#38bdf8',
                    yAxisID: 'y',
                },
                {
                    type: 'bar',
                    label: 'Orders',
                    data: @json($chart['orders']),
                    backgroundColor: 'rgba(245, 158, 11, .36)',
                    borderColor: 'rgba(245, 158, 11, .9)',
                    borderWidth: 1,
                    borderRadius: 8,
                    yAxisID: 'orders',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    display: true,
                    labels: { color: '#cbd5e1', usePointStyle: true, boxWidth: 8 },
                },
                tooltip: {
                    backgroundColor: '#020617',
                    borderColor: 'rgba(148, 163, 184, .22)',
                    borderWidth: 1,
                    callbacks: {
                        label(context) {
                            if (context.dataset.label === 'Revenue') {
                                return `Revenue: ${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 }).format(context.parsed.y || 0)}`;
                            }
                            return `Orders: ${context.parsed.y || 0}`;
                        },
                    },
                },
            },
            scales: {
                x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148,163,184,.1)' } },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#94a3b8',
                        callback: (value) => new Intl.NumberFormat('en-US', { notation: 'compact' }).format(value),
                    },
                    grid: { color: 'rgba(148,163,184,.12)' },
                },
                orders: {
                    position: 'right',
                    beginAtZero: true,
                    ticks: { color: '#fbbf24', precision: 0 },
                    grid: { drawOnChartArea: false },
                },
            },
        },
    });
});
</script>
@endsection
