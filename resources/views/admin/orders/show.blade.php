@extends('layouts.admin')
@section('title',$order->order_number)
@section('page-title',$order->order_number)
@section('page-description','Order detail, customer context, line items, and fulfillment timeline.')
@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_360px]">
    <section class="admin-card overflow-hidden">
        <div class="p-5"><p class="admin-kicker">Line Items</p><h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Order items</h2></div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0"><table><thead><tr><th>Item</th><th>SKU</th><th>Qty</th><th>Total</th></tr></thead><tbody>@foreach($order->items as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->sku }}</td><td>{{ $item->quantity }}</td><td>${{ number_format($item->total,2) }}</td></tr>@endforeach</tbody></table></div>
    </section>
    <aside class="space-y-6">
        <section class="admin-card p-5"><p class="admin-kicker">Customer</p><h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $order->customer?->name ?? 'Guest' }}</h2><p class="mb-0 mt-2 text-sm text-slate-500">{{ $order->customer?->email }}</p></section>
        <section class="admin-card p-5"><p class="admin-kicker">Timeline</p><h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Activity</h2>@forelse($order->timeline as $event)<div class="mt-4 border-l border-slate-200 pl-4"><p class="mb-0 font-semibold text-slate-950">{{ $event->event }}</p><p class="mb-0 text-xs text-slate-500">{{ $event->created_at->diffForHumans() }}</p></div>@empty<p class="mt-4 text-sm text-slate-500">No timeline events yet.</p>@endforelse</section>
    </aside>
</div>
@endsection
