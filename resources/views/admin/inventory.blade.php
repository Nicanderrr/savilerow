@extends('layouts.admin')
@section('title','Inventory')
@section('page-title','Inventory')
@section('page-description','Stock tracking, low-stock alerts, and restock management by variant.')
@section('content')
<section class="admin-card overflow-hidden">
    <div class="admin-panel-heading p-5">
        <div><p class="admin-kicker">Warehouse</p><h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Inventory control</h2></div>
        <span class="admin-badge-warning">{{ $variants->where('is_low_stock', true)->count() }} low stock</span>
    </div>
    <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
        <table>
            <thead><tr><th>Variant</th><th>Product</th><th>Size</th><th>Color</th><th>Stock</th><th>Threshold</th></tr></thead>
            <tbody>@foreach($variants as $variant)<tr><td>{{ $variant->sku }}</td><td>{{ $variant->product?->name }}</td><td>{{ $variant->size }}</td><td>{{ $variant->color }}</td><td><span class="{{ $variant->is_low_stock ? 'admin-badge-danger' : 'admin-badge-success' }}">{{ $variant->stock }}</span></td><td>{{ $variant->low_stock_threshold }}</td></tr>@endforeach</tbody>
        </table>
    </div>
    <div class="p-5">{{ $variants->links() }}</div>
</section>
@endsection
