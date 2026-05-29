@extends('layouts.storefront-normal')
@section('title', 'Bespoke | Savile Row')
@section('content')
<main id="main-content" class="bg-white">
    <section class="mx-auto max-w-4xl px-6 py-20 text-center md:py-28">
        <p class="text-label text-cl-muted">Bespoke tailoring</p>
        <h1 class="mt-4 font-serif text-4xl uppercase md:text-6xl">Commission your garment</h1>
        <p class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-cl-muted">Select cloth, silhouette, lining, and finishing details with the house before your first fitting.</p>
        <a href="/appointments" class="btn-red mt-8 inline-block">Book consultation</a>
    </section>
    <section class="border-y border-cl-gray-mid bg-cl-gray px-6 py-16">
        <div class="mx-auto grid max-w-5xl gap-4 md:grid-cols-3">
            @foreach([['Measure','A cutter records posture, balance, and measurements.'],['Cut','Your pattern is drafted and adjusted for the commission.'],['Fit','Final refinements are made through appointments.']] as [$title, $copy])
                <div class="bg-white p-6">
                    <p class="font-serif text-2xl uppercase">{{ $title }}</p>
                    <p class="mt-3 text-sm leading-7 text-cl-muted">{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
