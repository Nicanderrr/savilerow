<footer class="mt-auto bg-cl-black text-cl-white">
    <div class="mx-auto max-w-[1600px] px-6 py-10 md:py-12">
        <div class="border-b border-white/15 pb-8">
            <p class="font-serif text-2xl">Savile Row</p>
            <p class="mt-3 max-w-sm text-[12px] leading-relaxed text-white/65">Bespoke tailoring and luxury ready-to-wear since 1849. Mayfair, London.</p>
        </div>
        <nav class="grid gap-8 border-b border-white/15 py-8 md:grid-cols-4" aria-label="Footer">
            @foreach(['Shop'=>['Home'=>'/','All products'=>'/collections/all/products'], 'Help'=>['Contact us'=>'/policies/faq','Returns & exchanges'=>'/policies/returns','Visit our boutique'=>'/boutique','FAQ'=>'/policies/faq'], 'Services'=>['Book an appointment'=>'/appointments','Bespoke configurator'=>'/bespoke','Product care'=>'/policies/shipping'], 'Legal'=>['Terms of sale'=>'/policies/shipping','Privacy policy'=>'/policies/faq','Sitemap'=>'/collections/all/products']] as $title => $links)
                <div>
                    <p class="text-label text-white">{{ $title }}</p>
                    <ul class="mt-4 space-y-2">
                        @foreach($links as $label => $href)
                            <li><a href="{{ $href }}" class="text-[12px] text-white/75 hover:text-white">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>
        <div class="mt-6 flex flex-wrap items-center gap-4">
            <a href="/market" class="text-[10px] uppercase tracking-widest text-white/70 hover:text-white">United States / USD</a>
            <a href="https://instagram.com" class="text-[10px] uppercase tracking-widest text-white/70 hover:text-white">Instagram</a>
            <a href="https://tiktok.com" class="text-[10px] uppercase tracking-widest text-white/70 hover:text-white">TikTok</a>
            <a href="https://youtube.com" class="text-[10px] uppercase tracking-widest text-white/70 hover:text-white">YouTube</a>
        </div>
        <p class="mt-6 text-center text-[10px] text-white/45">&copy; {{ date('Y') }} Savile Row. All rights reserved.</p>
    </div>
</footer>
