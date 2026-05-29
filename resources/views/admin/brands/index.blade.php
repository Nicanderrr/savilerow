@extends('layouts.admin')
@section('title','Brands')
@section('page-title','Brands')
@section('page-description','Create and manage fashion houses, supplier labels, and brand metadata used by products.')
@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_380px]">
    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Catalog</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Brand directory</h2>
                <p class="mb-0 mt-2 text-sm text-slate-500">Brands appear as selectable labels when adding or editing products.</p>
            </div>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead><tr><th>Brand</th><th>Slug</th><th>Products</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="grid h-12 w-12 place-items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                        @if($brand->logo_path)
                                            <img src="{{ $brand->logo_path }}" alt="{{ $brand->name }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="font-serif text-lg font-semibold text-slate-700">{{ Str::upper(Str::substr($brand->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <span class="font-semibold text-slate-900">{{ $brand->name }}</span>
                                </div>
                            </td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->products_count }}</td>
                            <td>{{ $brand->is_active ? 'Active' : 'Inactive' }}</td>
                            <td class="text-end">
                                <button class="admin-btn-secondary py-2" data-bs-toggle="modal" data-bs-target="#editBrand{{ $brand->id }}">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-12 text-center text-slate-500">No brands yet. Create one, then assign products to it.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $brands->links() }}</div>
    </section>

    <aside class="admin-card p-5">
        <p class="admin-kicker">Create</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">New brand</h2>
        <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            @include('admin.brands.partials.form', ['brand' => new \App\Models\Brand()])
            <button class="admin-btn-primary w-full justify-center">Create brand</button>
        </form>
    </aside>
</div>

@foreach($brands as $brand)
    <div class="modal fade" id="editBrand{{ $brand->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $brand->name }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body space-y-4">
                        @include('admin.brands.partials.form', ['brand' => $brand])
                    </div>
                    <div class="modal-footer justify-between">
                        <button type="submit" form="deleteBrand{{ $brand->id }}" class="admin-btn-danger">Delete</button>
                        <button class="admin-btn-primary">Save changes</button>
                    </div>
                </form>
                <form id="deleteBrand{{ $brand->id }}" method="POST" action="{{ route('admin.brands.destroy', $brand) }}" onsubmit="return confirm('Delete this brand?')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
