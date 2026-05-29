@extends('layouts.admin')
@section('title','Analytics')
@section('page-title','Analytics')
@section('page-description','Traffic logs, visitor behavior, and order-origin geolocation reporting.')
@section('content')
<section class="admin-card p-5">
    <div class="admin-panel-heading">
        <div>
            <p class="admin-kicker">Network Intelligence</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Traffic and geolocation filters</h2>
        </div>
    </div>
    <form class="mt-5 grid gap-3 md:grid-cols-5">
        <input type="date" name="start" value="{{ $filters['start'] }}" class="admin-input">
        <input type="date" name="end" value="{{ $filters['end'] }}" class="admin-input">
        <select name="country" class="admin-select">
            <option value="">All countries</option>
            @foreach($countries as $country)
                <option value="{{ $country }}" @selected($filters['country'] === $country)>{{ $country }}</option>
            @endforeach
        </select>
        <select name="device" class="admin-select">
            <option value="">All devices</option>
            @foreach(['desktop','mobile','tablet'] as $device)
                <option value="{{ $device }}" @selected($filters['device'] === $device)>{{ Str::headline($device) }}</option>
            @endforeach
        </select>
        <div class="grid grid-cols-[1fr_auto] gap-2">
            <input name="path" value="{{ $filters['path'] }}" class="admin-input" placeholder="Path contains">
            <button class="admin-btn-primary">Filter</button>
        </div>
    </form>
</section>

<div class="admin-metric-grid mt-6">
    @foreach([
        ['Visits', number_format($stats['visits']), 'Total tracked requests', 'admin-badge-info'],
        ['Unique visitors', number_format($stats['visitors']), 'Distinct IP hash count', 'admin-badge-success'],
        ['Paid orders', number_format($stats['orders']), 'Orders in this range', 'admin-badge-warning'],
        ['Geo revenue', '$'.number_format($stats['revenue'], 0), 'Paid order revenue', 'admin-badge-muted'],
    ] as [$label,$value,$hint,$badge])
        <div class="admin-card p-5">
            <div class="flex items-start justify-between gap-4">
                <p class="admin-kicker">{{ $label }}</p>
                <span class="{{ $badge }}">Live</span>
            </div>
            <p class="mb-1 mt-5 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $value }}</p>
            <p class="mb-0 text-sm text-slate-500 dark:text-slate-400">{{ $hint }}</p>
        </div>
    @endforeach
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_.75fr]">
    <section class="admin-chart-shell">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker text-slate-400">Traffic Trend</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-white">Visits against unique visitors</h2>
            </div>
            <span class="admin-badge-warning">{{ $filters['start'] }} - {{ $filters['end'] }}</span>
        </div>
        <div class="admin-chart-frame mt-6">
            <canvas id="trafficChart" class="admin-chart-canvas"></canvas>
        </div>
    </section>

    <section class="admin-card p-5">
        <p class="admin-kicker">Countries</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Top visitor countries</h2>
        <div class="mt-5 space-y-3">
            @forelse($countryTraffic as $row)
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <div class="flex items-center justify-between gap-3">
                        <p class="mb-0 font-semibold text-slate-950">{{ $row->country_name }}</p>
                        <span class="admin-badge-info">{{ number_format($row->visits) }}</span>
                    </div>
                    <p class="mb-0 mt-1 text-xs text-slate-500">{{ number_format($row->visitors) }} unique visitors</p>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-200 p-5 text-sm text-slate-500">No traffic for this filter yet.</div>
            @endforelse
        </div>
    </section>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Order Origin</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Where paid orders come from</h2>
            </div>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead><tr><th>Country</th><th>Region</th><th>Orders</th><th>Revenue</th></tr></thead>
                <tbody>
                    @forelse($orderOrigins as $row)
                        <tr>
                            <td>{{ $row->country_name }}</td>
                            <td>{{ $row->region_name }}</td>
                            <td>{{ number_format($row->orders) }}</td>
                            <td>${{ number_format($row->revenue, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-500">No paid orders match this filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Network Traffic</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Top visited paths</h2>
            </div>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead><tr><th>Path</th><th>Visits</th><th>Visitors</th><th>Avg. ms</th></tr></thead>
                <tbody>
                    @forelse($topPages as $row)
                        <tr>
                            <td class="max-w-[260px] truncate">{{ $row->path }}</td>
                            <td>{{ number_format($row->visits) }}</td>
                            <td>{{ number_format($row->visitors) }}</td>
                            <td>{{ number_format($row->avg_duration, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-500">No traffic logs match this filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('trafficChart');
    if (!el || !window.Chart) return;

    new Chart(el, {
        data: {
            labels: @json($trafficLabels),
            datasets: [
                {
                    type: 'line',
                    label: 'Visits',
                    data: @json($trafficVisits),
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56,189,248,.16)',
                    fill: true,
                    tension: .4,
                    borderWidth: 3,
                },
                {
                    type: 'bar',
                    label: 'Unique visitors',
                    data: @json($trafficVisitors),
                    backgroundColor: 'rgba(245,158,11,.38)',
                    borderRadius: 8,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { labels: { color: '#cbd5e1', usePointStyle: true } },
            },
            scales: {
                x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148,163,184,.1)' } },
                y: { beginAtZero: true, ticks: { color: '#94a3b8', precision: 0 }, grid: { color: 'rgba(148,163,184,.12)' } },
            },
        },
    });
});
</script>
@endsection
