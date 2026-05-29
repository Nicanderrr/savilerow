@extends('layouts.admin')
@section('title','Staff & Roles')
@section('page-title','Staff & Roles')
@section('page-description','Control team access, role assignments, and operational permissions for the admin workspace.')
@section('content')
<div class="grid gap-6 xl:grid-cols-[360px_1fr]">
    <section class="admin-card p-5">
        <div class="admin-panel-heading">
            <div>
                <p class="admin-kicker">Access Model</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Roles</h2>
            </div>
            <span class="admin-badge-info">{{ $roles->count() }} roles</span>
        </div>
        <div class="mt-5 space-y-3">
            @foreach($roles as $role)
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <p class="mb-0 font-semibold text-slate-950">{{ $role->label }}</p>
                        <span class="admin-badge-muted">{{ $role->users_count }}</span>
                    </div>
                    <p class="mb-0 mt-2 text-xs text-slate-500">{{ $role->users_count }} users assigned</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="admin-card overflow-hidden">
        <div class="admin-panel-heading p-5">
            <div>
                <p class="admin-kicker">Governance</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Staff accounts</h2>
            </div>
            <span class="admin-badge-warning">{{ number_format($users->total()) }} users</span>
        </div>
        <div class="admin-table-wrap rounded-none border-x-0 border-b-0">
            <table>
                <thead>
                    <tr><th>User</th><th>Email</th><th>Roles</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($user->roles as $role)
                                        <span class="admin-badge-muted">{{ $role->label }}</span>
                                    @empty
                                        <span class="admin-badge-warning">No role</span>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-slate-500">No staff accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $users->links() }}</div>
    </section>
</div>
@endsection
