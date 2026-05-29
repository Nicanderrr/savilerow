@extends('layouts.admin')
@section('title','Settings')
@section('page-title','Settings: '.Str::headline($section))
@section('page-description','Configure store identity, currency, localization, payments, shipping, taxes, and theme settings.')
@section('content')
@php
    $hero = array_merge([
        'eyebrow' => 'New collection',
        'title' => 'Spring / Summer 2026',
        'button_label' => 'Discover',
        'button_url' => '/collections/all/products',
        'media_type' => 'video',
        'image' => '/images/products/hero-poster.jpg',
        'video' => '/video/hero1.mp4',
    ], $settings->get('home_hero')?->value ?? []);
    $sidebar = array_merge([
        'eyebrow' => 'Mayfair house',
        'title' => 'Savile Row',
        'description' => 'Tailoring, leather goods, and private service from the house.',
        'design' => 'modern',
        'cta_label' => 'Shop new arrivals',
        'cta_url' => '/collections/all/products',
        'hero_image' => '/images/products/tailoring.jpg',
        'cards' => [
            ['label' => 'All products', 'url' => '/collections/all/products', 'image' => '/images/products/hero-poster.jpg'],
            ['label' => 'Featured products', 'url' => '/collections/all/products', 'image' => '/images/products/hero-poster.jpg'],
            ['label' => 'New arrivals', 'url' => '/collections/all/products', 'image' => '/images/products/hero-poster.jpg'],
        ],
    ], $settings->get('menu_sidebar')?->value ?? []);
@endphp

@if($section === 'themes')
    <form method="POST" action="{{ route('admin.settings.update', ['section' => 'themes']) }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_380px]">
        @csrf

        <div class="space-y-6">
        <section class="admin-card p-5">
            <p class="admin-kicker">Theme Editor</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Homepage hero</h2>
            <p class="mt-2 text-sm text-slate-500">Control the first impression on the storefront: hero copy, CTA, fallback image, and motion video.</p>

            <div class="mt-6 grid gap-4">
                <div>
                    <label class="form-label fw-semibold text-slate-700">Displayed media</label>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400">
                            <input type="radio" name="hero_media_type" value="image" class="form-check-input" @checked(old('hero_media_type', $hero['media_type']) === 'image')>
                            Use image
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-400">
                            <input type="radio" name="hero_media_type" value="video" class="form-check-input" @checked(old('hero_media_type', $hero['media_type']) === 'video')>
                            Use video
                        </label>
                    </div>
                    @error('hero_media_type')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label fw-semibold text-slate-700">Eyebrow</label>
                    <input name="hero_eyebrow" value="{{ old('hero_eyebrow', $hero['eyebrow']) }}" class="admin-input" placeholder="New collection">
                    @error('hero_eyebrow')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label fw-semibold text-slate-700">Hero title</label>
                    <input name="hero_title" value="{{ old('hero_title', $hero['title']) }}" class="admin-input" required placeholder="Spring / Summer 2026">
                    @error('hero_title')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Button label</label>
                        <input name="hero_button_label" value="{{ old('hero_button_label', $hero['button_label']) }}" class="admin-input" placeholder="Discover">
                        @error('hero_button_label')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Button URL</label>
                        <input name="hero_button_url" value="{{ old('hero_button_url', $hero['button_url']) }}" class="admin-input" placeholder="/collections/all/products">
                        @error('hero_button_url')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </section>

        <section class="admin-card p-5">
            <p class="admin-kicker">Sidebar Designer</p>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Storefront menu drawer</h2>
            <p class="mt-2 text-sm text-slate-500">Choose between the image-led luxury drawer and a clean normal sidebar, then edit the copy and thumbnail content.</p>

            <div class="mt-6 grid gap-5">
                <div>
                    <label class="form-label fw-semibold text-slate-700">Sidebar theme design</label>
                    <div class="grid gap-3 md:grid-cols-2">
                        <label class="cursor-pointer rounded-3xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-slate-400 has-[:checked]:border-slate-950 has-[:checked]:ring-2 has-[:checked]:ring-slate-950/10">
                            <input type="radio" name="sidebar_design" value="modern" class="form-check-input" @checked(old('sidebar_design', $sidebar['design']) === 'modern')>
                            <span class="ml-2 text-sm font-semibold text-slate-900">Modern picture sidebar</span>
                            <span class="mt-3 block overflow-hidden rounded-2xl border border-slate-200 bg-slate-950 p-3">
                                <span class="block h-20 rounded-xl bg-[linear-gradient(135deg,#111,#5b4630)]"></span>
                                <span class="mt-3 grid gap-2">
                                    <span class="block h-8 rounded-lg bg-slate-700"></span>
                                    <span class="block h-8 rounded-lg bg-slate-700"></span>
                                </span>
                            </span>
                            <span class="mt-3 block text-xs leading-5 text-slate-500">Current editorial drawer with hero image and thumbnail cards.</span>
                        </label>
                        <label class="cursor-pointer rounded-3xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-slate-400 has-[:checked]:border-slate-950 has-[:checked]:ring-2 has-[:checked]:ring-slate-950/10">
                            <input type="radio" name="sidebar_design" value="classic" class="form-check-input" @checked(old('sidebar_design', $sidebar['design']) === 'classic')>
                            <span class="ml-2 text-sm font-semibold text-slate-900">Normal clean sidebar</span>
                            <span class="mt-3 block rounded-2xl border border-slate-200 bg-[#fbfaf7] p-3">
                                <span class="block h-4 w-28 bg-slate-950"></span>
                                <span class="mt-4 grid gap-2">
                                    <span class="block h-9 border border-slate-300 bg-white"></span>
                                    <span class="block h-9 border border-slate-300 bg-white"></span>
                                    <span class="block h-9 border border-slate-300 bg-white"></span>
                                </span>
                            </span>
                            <span class="mt-3 block text-xs leading-5 text-slate-500">No picture-heavy hero. Simple links, categories, services, and CTA.</span>
                        </label>
                    </div>
                    @error('sidebar_design')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Sidebar eyebrow</label>
                        <input name="sidebar_eyebrow" value="{{ old('sidebar_eyebrow', $sidebar['eyebrow']) }}" class="admin-input">
                        @error('sidebar_eyebrow')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Sidebar title</label>
                        <input name="sidebar_title" value="{{ old('sidebar_title', $sidebar['title']) }}" class="admin-input" required>
                        @error('sidebar_title')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="form-label fw-semibold text-slate-700">Sidebar description</label>
                    <textarea name="sidebar_description" class="admin-textarea" rows="3">{{ old('sidebar_description', $sidebar['description']) }}</textarea>
                    @error('sidebar_description')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">CTA label</label>
                        <input name="sidebar_cta_label" value="{{ old('sidebar_cta_label', $sidebar['cta_label']) }}" class="admin-input">
                        @error('sidebar_cta_label')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-semibold text-slate-700">CTA URL</label>
                        <input name="sidebar_cta_url" value="{{ old('sidebar_cta_url', $sidebar['cta_url']) }}" class="admin-input">
                        @error('sidebar_cta_url')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-5 lg:grid-cols-[260px_1fr]">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Drawer hero background</label>
                        <div id="sidebar-hero-preview" class="mt-2 overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                            <img src="{{ $sidebar['hero_image'] }}" alt="Sidebar hero" class="aspect-square w-full object-cover">
                        </div>
                        <label class="admin-btn-secondary mt-3 w-full cursor-pointer justify-center">
                            Upload background
                            <input type="file" name="sidebar_hero_image" accept="image/jpeg,image/png,image/webp,image/avif" class="sr-only" data-single-image-preview-input="#sidebar-hero-preview">
                        </label>
                        @error('sidebar_hero_image')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold text-slate-700">Featured collection thumbnails</label>
                        <div class="mt-2 grid gap-4 md:grid-cols-3">
                            @foreach($sidebar['cards'] as $index => $card)
                                <div class="rounded-3xl border border-slate-200 bg-white p-3">
                                    <div id="sidebar-card-preview-{{ $index }}" class="overflow-hidden rounded-2xl bg-slate-100">
                                        <img src="{{ $card['image'] }}" alt="{{ $card['label'] }}" class="aspect-square w-full object-cover">
                                    </div>
                                    <div class="mt-3 grid gap-2">
                                        <input name="sidebar_cards[{{ $index }}][label]" value="{{ old("sidebar_cards.$index.label", $card['label']) }}" class="admin-input" placeholder="Card label" required>
                                        <input name="sidebar_cards[{{ $index }}][url]" value="{{ old("sidebar_cards.$index.url", $card['url']) }}" class="admin-input" placeholder="/collections/all/products" required>
                                        <label class="admin-btn-secondary w-full cursor-pointer justify-center py-2">
                                            Upload thumbnail
                                            <input type="file" name="sidebar_card_images[{{ $index }}]" accept="image/jpeg,image/png,image/webp,image/avif" class="sr-only" data-single-image-preview-input="#sidebar-card-preview-{{ $index }}">
                                        </label>
                                    </div>
                                    @error("sidebar_cards.$index.label")<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                                    @error("sidebar_cards.$index.url")<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                                    @error("sidebar_card_images.$index")<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>

        <aside class="space-y-6">
            <section class="admin-card p-5">
                <p class="admin-kicker">Media</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Hero media</h2>
                <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-1">
                    <div>
                        <label class="form-label fw-semibold text-slate-700">Hero image / poster</label>
                        <div id="hero-image-preview" class="mt-2 overflow-hidden rounded-3xl border border-slate-200 bg-slate-100">
                            <img src="{{ $hero['image'] }}" alt="Current hero image" class="aspect-square w-full object-cover">
                        </div>
                        <label class="admin-btn-secondary mt-3 w-full cursor-pointer justify-center">
                            Upload hero image
                            <input type="file" name="hero_image" accept="image/jpeg,image/png,image/webp,image/avif" class="sr-only" data-single-image-preview-input="#hero-image-preview">
                        </label>
                        @error('hero_image')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label fw-semibold text-slate-700">Hero video</label>
                        <div id="hero-video-preview" class="mt-2 overflow-hidden rounded-3xl border border-slate-200 bg-black">
                            <video src="{{ $hero['video'] }}" poster="{{ $hero['image'] }}" class="aspect-square w-full object-cover" muted loop playsinline controls></video>
                        </div>
                        <label class="admin-btn-secondary mt-3 w-full cursor-pointer justify-center">
                            Upload hero video
                            <input type="file" name="hero_video" accept="video/mp4,video/webm,video/quicktime" class="sr-only" data-video-preview-input="#hero-video-preview">
                        </label>
                        <p class="mt-2 text-xs text-slate-500">MP4, WebM, or MOV. Keep the final production video compressed for fast mobile loading.</p>
                        @error('hero_video')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <button class="admin-btn-primary w-full py-3">Save theme hero</button>
        </aside>
    </form>
@else
    <section class="admin-card p-5">
        <p class="admin-kicker">Configuration</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 dark:text-white">Store settings</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <div><label class="form-label fw-semibold text-slate-700">Store name</label><input class="admin-input" value="Savile Row"></div>
            <div><label class="form-label fw-semibold text-slate-700">Default currency</label><select class="admin-select"><option>USD</option><option>GBP</option><option>EUR</option></select></div>
            <div><label class="form-label fw-semibold text-slate-700">Timezone</label><input class="admin-input" value="UTC"></div>
            <div><label class="form-label fw-semibold text-slate-700">Locale</label><input class="admin-input" value="en"></div>
        </div>
        <button class="admin-btn-primary mt-5">Save settings</button>
    </section>
@endif
@endsection
