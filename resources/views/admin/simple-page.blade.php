@extends('layouts.admin')
@section('title',$title)
@section('page-title',$title)
@section('page-description',$description)
@section('content')
<div class="grid gap-4 sm:grid-cols-3">
    @foreach($metrics as $label => $value)
        <div class="admin-card p-5">
            <p class="admin-kicker">{{ $label }}</p>
            <p class="mb-0 mt-4 text-4xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $value }}</p>
        </div>
    @endforeach
</div>
<section class="admin-card mt-6 p-5">
    <p class="admin-kicker">Workspace</p>
    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">{{ $title }}</h2>
    <p class="mb-0 mt-2 text-slate-500">{{ $description }}</p>
</section>
@endsection
