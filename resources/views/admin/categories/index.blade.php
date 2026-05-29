@extends('layouts.admin')
@section('title','Categories')
@section('page-title','Categories')
@section('page-description','Create the storefront collections used by product listing pages, filters, and homepage collection cards.')
@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_380px]">
    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Merchandising</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Collection taxonomy</h2>
                <p class="mb-0 mt-2 text-sm text-slate-500">Only categories with published products appear on the storefront.</p>
            </div>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead><tr><th>Category</th><th>Parent</th><th>Slug</th><th>Sort</th><th>Featured</th><th></th></tr></thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img class="h-12 w-12 rounded-xl object-cover" src="{{ $category->image_path ?: '/images/products/hero-poster.jpg' }}" alt="">
                                    <span class="font-semibold text-slate-900">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>{{ $category->parent?->name ?: 'None' }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->sort_order }}</td>
                            <td>{{ $category->is_featured ? 'Yes' : 'No' }}</td>
                            <td class="text-end">
                                <button class="admin-btn-secondary py-2" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-12 text-center text-slate-500">No categories yet. Create one, then assign products to it.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $categories->links() }}</div>
    </section>

    <aside class="admin-card p-5">
        <p class="admin-kicker">Create</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">New category</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            @include('admin.categories.partials.form', ['category' => new \App\Models\Category(), 'parents' => $parents])
            <button class="admin-btn-primary w-full justify-center">Create category</button>
        </form>
    </aside>
</div>

@foreach($categories as $category)
    <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $category->name }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body space-y-4">
                        @include('admin.categories.partials.form', ['category' => $category, 'parents' => $parents->where('id', '!=', $category->id)])
                    </div>
                    <div class="modal-footer justify-between">
                        <button type="submit" form="deleteCategory{{ $category->id }}" class="admin-btn-danger">Delete</button>
                        <button class="admin-btn-primary">Save changes</button>
                    </div>
                </form>
                <form id="deleteCategory{{ $category->id }}" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
