<footer class="mt-auto border-t border-cl-gray-mid bg-white">
    <div class="mx-auto max-w-[1600px] px-6 py-10 md:py-12">
        <div class="border-b border-cl-gray-mid pb-8">
            <p class="font-serif text-2xl">Savile Row</p>
            <p class="mt-3 max-w-sm text-[12px] leading-relaxed text-cl-muted">Bespoke tailoring and luxury ready-to-wear since 1849.</p>
        </div>
        <nav class="grid gap-8 border-b border-cl-gray-mid py-8 md:grid-cols-4" aria-label="Footer">
            @foreach(['Shop'=>['Home'=>'/','All products'=>'/collections/all/products'], 'Help'=>['Contact us'=>'/policies/faq','Returns & exchanges'=>'/policies/returns','Visit our boutique'=>'/boutique','FAQ'=>'/policies/faq'], 'Services'=>['Book an appointment'=>'/appointments','Bespoke configurator'=>'/bespoke','Product care'=>'/policies/shipping'], 'Legal'=>['Terms of sale'=>'/policies/shipping','Privacy policy'=>'/policies/faq','Sitemap'=>'/collections/all/products']] as $title => $links)
                <div>
                    <p class="text-label">{{ $title }}</p>
                    <ul class="mt-4 space-y-2">
                        @foreach($links as $label => $href)
                            <li><a href="{{ $href }}" class="text-[12px] text-cl-muted hover:text-black">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>
        <p class="mt-6 text-center text-[10px] text-cl-muted">&copy; {{ date('Y') }} Savile Row. All rights reserved.</p>
    </div>
</footer>
