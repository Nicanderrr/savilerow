@extends('layouts.admin')
@section('title','Profile')
@section('page-title','Profile')
@section('page-description','Manage the active administrator profile and account identity.')
@section('content')
<section class="admin-card max-w-3xl p-5">
    <p class="admin-kicker">Account</p>
    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Admin profile</h2>
    <div class="mt-5 grid gap-4">
        <input class="admin-input" value="{{ auth()->user()->name }}">
        <input class="admin-input" value="{{ auth()->user()->email }}">
        <button class="admin-btn-primary w-fit">Update profile</button>
    </div>
</section>
@endsection
