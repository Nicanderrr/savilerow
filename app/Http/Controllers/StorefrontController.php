<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Support\Catalog;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $hero = Schema::hasTable('settings')
            ? Setting::where('group', 'themes')->where('key', 'home_hero')->first()?->value ?? []
            : [];

        return view('storefront.home', [
            'featured' => Catalog::featured(),
            'hero' => array_merge([
                'eyebrow' => 'New collection',
                'title' => 'Spring / Summer 2026',
                'button_label' => 'Discover',
                'button_url' => '/collections/men/suits',
                'media_type' => 'video',
                'image' => '/images/products/hero-poster.jpg',
                'video' => '/video/hero1.mp4',
            ], $hero),
        ]);
    }

    public function allProducts(): View
    {
        $products = $this->filterProducts(Catalog::all());

        return view('storefront.collection', [
            'title' => 'All products',
            'eyebrow' => 'Savile Row catalog',
            'products' => $products,
            'gender' => 'all',
            'category' => 'products',
            'facets' => $this->facets(),
        ]);
    }

    public function collection(string $gender, string $category): View
    {
        $collection = Catalog::collection($gender, $category);

        abort_if(empty($collection), 404);

        $products = $this->filterProducts($collection);

        return view('storefront.collection', [
            'title' => ucfirst($gender).' '.str_replace('-', ' ', $category),
            'eyebrow' => 'Collection',
            'products' => $products,
            'gender' => $gender,
            'category' => $category,
            'facets' => $this->facets(),
        ]);
    }

    public function product(string $slug): View
    {
        $product = Catalog::find($slug);

        abort_if($product === null, 404);

        return view('storefront.product', [
            'product' => $product,
            'related' => Catalog::related($product),
        ]);
    }

    public function simple(string $view): View
    {
        return view('storefront.'.$view);
    }

    public function policy(string $view): View
    {
        return view('policies.'.$view);
    }

    private function filterProducts(array $products): array
    {
        $search = (string) str(request('search', ''))->lower()->trim();
        $sort = request('sort', 'featured');

        if ($search !== '') {
            $products = array_values(array_filter($products, function (array $product) use ($search) {
                return str($product['name'].' '.$product['category'].' '.$product['gender'].' '.$product['description'])
                    ->lower()
                    ->contains($search);
            }));
        }

        return match ($sort) {
            'price-asc' => collect($products)->sortBy('price')->values()->all(),
            'price-desc' => collect($products)->sortByDesc('price')->values()->all(),
            'newest' => collect($products)->sortByDesc(fn ($product) => $product['isNew'] ?? false)->values()->all(),
            default => $products,
        };
    }

    private function facets(): array
    {
        return [
            ['label' => 'All products', 'href' => route('collections.all'), 'key' => 'all-products'],
            ['label' => 'Men suits', 'href' => route('collections.show', ['gender' => 'men', 'category' => 'suits']), 'key' => 'men-suits'],
            ['label' => 'Men shoes', 'href' => route('collections.show', ['gender' => 'men', 'category' => 'shoes']), 'key' => 'men-shoes'],
            ['label' => 'Women bags', 'href' => route('collections.show', ['gender' => 'women', 'category' => 'bags']), 'key' => 'women-bags'],
            ['label' => 'Women perfumes', 'href' => route('collections.show', ['gender' => 'women', 'category' => 'perfumes']), 'key' => 'women-perfumes'],
            ['label' => 'Kids tailoring', 'href' => route('collections.show', ['gender' => 'kids', 'category' => 'suits']), 'key' => 'kids-suits'],
        ];
    }
}

