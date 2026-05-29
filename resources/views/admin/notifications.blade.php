@extends('layouts.admin')
@section('title','Notifications')
@section('page-title','Notifications')
@section('page-description','Operational alerts, inventory warnings, and admin activity messages.')
@section('content')
<section class="admin-card p-5">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <p class="admin-kicker">Alerts</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Notification center</h2>
        </div>
        <form method="POST" action="{{ route('admin.notifications.clear') }}">
            @csrf
            <button class="admin-btn-secondary" type="submit">Clear unread</button>
        </form>
    </div>
    <div class="mt-5 space-y-3">
        @forelse($notifications as $notification)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 text-current transition hover:border-amber-300 hover:bg-slate-50">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex min-w-0 gap-3">
                        <span class="admin-notification-dot mt-1 {{ $notification->type === 'payment' && ! $notification->read_at ? 'is-payment' : '' }} {{ $notification->read_at ? 'is-read' : '' }}"></span>
                        <div class="min-w-0">
                            <a href="{{ $notification->url ?? '#' }}" class="mb-0 block truncate font-semibold text-slate-950">{{ $notification->title }}</a>
                            <span class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @unless($notification->read_at)
                        <form method="POST" action="{{ route('admin.notifications.clear-one', $notification) }}">
                            @csrf
                            <button class="admin-btn-secondary py-2" type="submit">Clear</button>
                        </form>
                    @endunless
                </div>
                <p class="mb-0 mt-1 text-sm text-slate-500">{{ $notification->message }}</p>
            </div>
        @empty
            <p class="rounded-2xl border border-dashed border-slate-200 p-5 text-sm text-slate-500">No notifications.</p>
        @endforelse
    </div>
    <div class="mt-5">{{ $notifications->links() }}</div>
</section>
@endsection
