@extends('layouts.admin')
@section('title',$product->name)
@section('page-title',$product->name)
@section('page-description','Inspect gallery media, SKU data, product copy, and merchandising actions.')
@section('content')
<div class="grid gap-6 lg:grid-cols-[1fr_360px]">
    <section class="admin-card p-5">
        <p class="admin-kicker">Media</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Product Gallery</h2>
        <div class="mt-5 grid grid-cols-2 gap-3 md:grid-cols-3">@foreach($product->images as $image)<img src="{{ $image->path }}" class="aspect-[3/4] rounded-2xl object-cover">@endforeach</div>
    </section>
    <aside class="admin-card p-5">
        <span class="{{ $product->status === 'published' ? 'admin-badge-success' : 'admin-badge-muted' }}">{{ ucfirst($product->status) }}</span>
        <h2 class="mt-4 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $product->sku }}</h2>
        <p class="mt-3 text-sm text-slate-500">{{ $product->description }}</p>
        <div class="mt-5 flex flex-wrap gap-2"><a href="{{ route('admin.products.edit',$product) }}" class="admin-btn-primary">Edit product</a><form method="POST" action="{{ route('admin.products.duplicate',$product) }}">@csrf<button class="admin-btn-secondary">Duplicate</button></form></div>
    </aside>
</div>
@endsection
