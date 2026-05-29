@extends('layouts.admin')
@section('title','CMS')
@section('page-title','CMS: '.Str::headline($section))
@section('page-description','Manage homepage content, banners, blog entries, and lookbook presentation.')
@section('content')
<div class="grid gap-6 xl:grid-cols-2">
    <section class="admin-card p-5">
        <p class="admin-kicker">Homepage</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Hero and banners</h2>
        <div class="mt-5 space-y-3">@forelse($banners as $banner)<div class="rounded-2xl border border-slate-200 bg-white p-4"><p class="mb-0 font-semibold text-slate-950">{{ $banner->title }}</p><p class="mb-0 text-xs text-slate-500">{{ $banner->placement }}</p></div>@empty<p class="rounded-2xl border border-dashed border-slate-200 p-5 text-sm text-slate-500">No banners configured.</p>@endforelse</div>
    </section>
    <section class="admin-card p-5">
        <p class="admin-kicker">Content</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Editorial calendar</h2>
        <div class="mt-5 space-y-3">@forelse($posts as $post)<div class="rounded-2xl border border-slate-200 bg-white p-4"><p class="mb-0 font-semibold text-slate-950">{{ $post->title }}</p><p class="mb-0 text-xs text-slate-500">{{ $post->status }}</p></div>@empty<p class="rounded-2xl border border-dashed border-slate-200 p-5 text-sm text-slate-500">No posts yet.</p>@endforelse</div>
    </section>
</div>
@endsection
