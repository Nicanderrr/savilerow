<?php

namespace App\Http\Controllers;

use App\Models\{Category, Setting};
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
                'button_url' => '/collections/all/products',
                'media_type' => 'video',
                'image' => '/images/products/hero-poster.jpg',
                'video' => '/video/hero1.mp4',
            ], $hero),
            'collectionCards' => array_slice(Catalog::facets(), 0, 2),
            'editorialCards' => array_slice(Catalog::facets(), 0, 4),
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
        abort_if($category !== 'products' && ! Category::where('slug', $category)->exists(), 404);

        $collection = Catalog::collection($gender, $category);

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
        return array_merge([
            ['label' => 'All products', 'href' => route('collections.all'), 'key' => 'all-products'],
        ], Catalog::facets());
    }
}

