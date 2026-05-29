@extends('layouts.admin')
@section('title','Products')
@section('page-title','Products')
@section('page-description','Manage catalog publishing, pricing, SKU visibility, merchandising, and product editing workflows.')
@section('content')
<section class="admin-card overflow-hidden">
    <div class="admin-panel-heading p-5">
        <div>
            <p class="admin-kicker">Catalog Management</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">All Products</h2>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-btn-primary">Add Product</a>
    </div>
    <form class="grid gap-3 border-t border-slate-100 p-5 md:grid-cols-[1fr_180px_auto]">
        <input name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search name or SKU">
        <select name="status" class="admin-select"><option value="">All statuses</option>@foreach(['draft','published','archived'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>@endforeach</select>
        <button class="admin-btn-secondary">Filter</button>
    </form>
    <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
        <table>
            <thead><tr><th>Product</th><th>SKU</th><th>Status</th><th>Price</th><th>Category</th><th></th></tr></thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><div class="flex items-center gap-3"><img class="h-14 w-12 rounded-xl object-cover" src="{{ $product->images->first()->path ?? '/images/products/hero-poster.jpg' }}"><div><p class="mb-0 font-semibold text-slate-900">{{ $product->name }}</p><p class="mb-0 text-xs text-slate-500">{{ $product->brand?->name }}</p></div></div></td>
                        <td>{{ $product->sku }}</td>
                        <td><span class="{{ $product->status === 'published' ? 'admin-badge-success' : 'admin-badge-muted' }}">{{ ucfirst($product->status) }}</span></td>
                        <td>${{ number_format($product->price,0) }}</td>
                        <td>{{ $product->category?->name }}</td>
                        <td class="text-end"><a class="admin-btn-secondary py-2" href="{{ route('admin.products.edit',$product) }}">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-12 text-center text-slate-500">No products match this filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5">{{ $products->links() }}</div>
</section>
@endsection
