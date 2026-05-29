@extends('layouts.admin')
@section('title',$title)
@section('page-title',$title)
@section('page-description',$description)
@section('content')
<section class="admin-card overflow-hidden">
    <div class="admin-panel-heading p-5">
        <div><p class="admin-kicker">Operations</p><h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $title }}</h2><p class="mb-0 mt-2 text-sm text-slate-500">{{ $description }}</p></div>
        <button class="admin-btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
    <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
        <table>
            <thead><tr>@foreach($columns as $column)<th>{{ Str::headline($column) }}</th>@endforeach<th></th></tr></thead>
            <tbody>
                @forelse($items as $item)
                    <tr>@foreach($columns as $column)<td>{{ is_bool($item->{$column}) ? ($item->{$column} ? 'Yes' : 'No') : $item->{$column} }}</td>@endforeach<td class="text-end"><button class="admin-btn-secondary py-2">Edit</button></td></tr>
                @empty
                    <tr><td colspan="{{ count($columns)+1 }}" class="py-12 text-center text-slate-500">No records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-5">{{ $items->links() }}</div>
</section>
<div class="modal fade" id="createModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content rounded-4 border-0"><div class="modal-header"><h5 class="modal-title">Create {{ $title }}</h5><button class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p class="text-muted">Use the service layer endpoint for production creation workflows.</p></div></div></div></div>
@endsection
