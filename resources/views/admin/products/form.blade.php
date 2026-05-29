@extends('layouts.admin')
@section('title', $product->exists ? 'Edit Product' : 'Add Product')
@section('page-title', $product->exists ? 'Edit Product' : 'Add Product')
@section('page-description','Create and refine product merchandising, publishing, pricing, SEO, and catalog relationships.')
@section('content')
<form method="POST" action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_360px]">
    @csrf
    @if($product->exists) @method('PUT') @endif

    <div class="space-y-6">
        <section class="admin-card p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="admin-kicker">Media</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Product gallery</h2>
                    <p class="mt-2 text-sm text-slate-500">Upload product photography. The first image is used as the catalog thumbnail.</p>
                </div>
                <label class="admin-btn-secondary cursor-pointer">
                    Upload images
                    <input type="file" name="images[]" accept="image/jpeg,image/png,image/webp,image/avif" multiple class="sr-only" data-image-preview-input="#product-image-preview">
                </label>
            </div>
            @error('images.*')<p class="mt-3 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4" id="product-image-preview">
                @forelse($product->images ?? [] as $image)
                    <label class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                        <img src="{{ $image->path }}" alt="{{ $image->alt_text ?: $product->name }}" class="aspect-[3/4] w-full object-cover">
                        <span class="absolute left-3 top-3 rounded-full bg-black/70 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white">Current</span>
                        <span class="absolute inset-x-3 bottom-3 flex items-center justify-center gap-2 rounded-2xl bg-white/95 px-3 py-2 text-xs font-bold uppercase tracking-widest text-slate-900 shadow-lg">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input">
                            Remove
                        </span>
                    </label>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-4">
                        No gallery images yet. Upload one or more images to preview them here before saving.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="admin-card p-5">
            <p class="admin-kicker">Catalog</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Product details</h2>
            <div class="mt-5 grid gap-4">
                <div><label class="form-label fw-semibold text-slate-700">Name</label><input name="name" value="{{ old('name',$product->name) }}" class="admin-input" required></div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div><label class="form-label fw-semibold text-slate-700">Slug</label><input name="slug" value="{{ old('slug',$product->slug) }}" class="admin-input"></div>
                    <div><label class="form-label fw-semibold text-slate-700">SKU</label><input name="sku" value="{{ old('sku',$product->sku) }}" class="admin-input" placeholder="Auto-generated"></div>
                </div>
                <div><label class="form-label fw-semibold text-slate-700">Short description</label><textarea name="short_description" class="admin-textarea" rows="2">{{ old('short_description',$product->short_description) }}</textarea></div>
                <div><label class="form-label fw-semibold text-slate-700">Rich description</label><textarea name="description" class="admin-textarea" rows="8">{{ old('description',$product->description) }}</textarea></div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div><label class="form-label fw-semibold text-slate-700">SEO title</label><input name="seo_title" value="{{ old('seo_title',$product->seo_title) }}" class="admin-input"></div>
                    <div><label class="form-label fw-semibold text-slate-700">Tags</label><input name="tags" value="{{ old('tags', implode(',', $product->tags ?? [])) }}" class="admin-input" placeholder="bespoke, new, evening"></div>
                </div>
                <div><label class="form-label fw-semibold text-slate-700">SEO description</label><textarea name="seo_description" class="admin-textarea" rows="2">{{ old('seo_description',$product->seo_description) }}</textarea></div>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="admin-card p-5">
            <p class="admin-kicker">Publishing</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Status</h2>
            <div class="mt-4 space-y-4">
                <div><label class="form-label fw-semibold text-slate-700">Status</label><select name="status" class="admin-select">@foreach(['draft','published','archived'] as $status)<option value="{{ $status }}" @selected(old('status',$product->status ?: 'draft')===$status)>{{ ucfirst($status) }}</option>@endforeach</select></div>
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700"><input type="checkbox" name="is_featured" value="1" class="form-check-input" @checked(old('is_featured',$product->is_featured))> Featured product</label>
            </div>
        </section>

        <section class="admin-card p-5">
            <p class="admin-kicker">Commercial</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Pricing</h2>
            <div class="mt-4 grid gap-4">
                <div><label class="form-label fw-semibold text-slate-700">Price</label><input name="price" type="number" step="0.01" value="{{ old('price',$product->price) }}" class="admin-input" required></div>
                <div><label class="form-label fw-semibold text-slate-700">Compare at price</label><input name="compare_at_price" type="number" step="0.01" value="{{ old('compare_at_price',$product->compare_at_price) }}" class="admin-input"></div>
                <div><label class="form-label fw-semibold text-slate-700">Brand</label><select name="brand_id" class="admin-select"><option value="">None</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected(old('brand_id',$product->brand_id)==$brand->id)>{{ $brand->name }}</option>@endforeach</select></div>
                <div><label class="form-label fw-semibold text-slate-700">Category</label><select name="category_id" class="admin-select"><option value="">None</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
            </div>
        </section>

        <button class="admin-btn-primary w-full py-3">Save product</button>
    </aside>
</form>
@endsection
