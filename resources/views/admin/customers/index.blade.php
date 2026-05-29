@extends('layouts.admin')
@section('title','Customers')
@section('page-title','Customers')
@section('page-description','Review client profiles, loyalty standing, purchase volume, and account health.')
@section('content')
<div class="grid gap-4 md:grid-cols-3">
    <div class="admin-card p-5">
        <p class="admin-kicker">Total Customers</p>
        <p class="mb-1 mt-4 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ number_format($customers->total()) }}</p>
        <p class="mb-0 text-sm text-slate-500">Profiles in the current database.</p>
    </div>
    <div class="admin-card p-5">
        <p class="admin-kicker">Loyalty Points</p>
        <p class="mb-1 mt-4 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ number_format($customers->sum('loyalty_points')) }}</p>
        <p class="mb-0 text-sm text-slate-500">Visible on this page.</p>
    </div>
    <div class="admin-card p-5">
        <p class="admin-kicker">Order Links</p>
        <p class="mb-1 mt-4 text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ number_format($customers->sum('orders_count')) }}</p>
        <p class="mb-0 text-sm text-slate-500">Purchases tied to listed customers.</p>
    </div>
</div>

<section class="admin-card mt-6 overflow-hidden">
    <div class="admin-panel-heading p-5">
        <div>
            <p class="admin-kicker">Clienteling</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Customer profiles</h2>
        </div>
        <form class="flex w-full gap-3 md:w-auto" action="{{ route('admin.customers.index') }}">
            <input name="search" class="admin-input md:w-72" value="{{ request('search') }}" placeholder="Search customers">
            <button class="admin-btn-primary" type="submit">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Status</th><th>Loyalty</th><th>Orders</th></tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="font-semibold text-slate-900">{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td><span class="{{ $customer->status === 'active' ? 'admin-badge-success' : 'admin-badge-warning' }}">{{ ucfirst($customer->status) }}</span></td>
                        <td>{{ number_format($customer->loyalty_points) }}</td>
                        <td>{{ number_format($customer->orders_count) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-500">No customer profiles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5">{{ $customers->links() }}</div>
</section>
@endsection
