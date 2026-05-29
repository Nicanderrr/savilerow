@extends('layouts.admin')
@section('title','Orders')
@section('page-title','Orders')
@section('page-description','Track order status, payment state, customer ownership, and export-ready fulfillment records.')
@section('content')
<section class="admin-card overflow-hidden">
    <div class="admin-panel-heading p-5">
        <div>
            <p class="admin-kicker">Fulfillment</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Orders</h2>
        </div>
        <button class="admin-btn-secondary">Export CSV</button>
    </div>
    <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
        <table>
            <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th>Payment</th><th>Total</th><th>Placed</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show',$order) }}">{{ $order->order_number }}</a></td>
                        <td>{{ $order->customer?->name ?? 'Guest' }}</td>
                        <td><span class="admin-badge-info">{{ ucfirst($order->status) }}</span></td>
                        <td><span class="admin-badge-muted">{{ ucfirst($order->payment_status) }}</span></td>
                        <td>${{ number_format($order->total,2) }}</td>
                        <td>{{ $order->placed_at?->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-12 text-center text-slate-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5">{{ $orders->links() }}</div>
</section>
@endsection
