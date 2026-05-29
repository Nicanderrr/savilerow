<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class Catalog
{
    public static function all(): array
    {
        if (! self::tablesReady()) {
            return [];
        }

        return self::publishedQuery()
            ->latest('published_at')
            ->latest()
            ->get()
            ->map(fn (Product $product) => self::present($product))
            ->all();
    }

    public static function find(string $slug): ?array
    {
        if (! self::tablesReady()) {
            return null;
        }

        $product = self::publishedQuery()->where('slug', $slug)->first();

        return $product ? self::present($product) : null;
    }

    public static function collection(string $gender, string $category): array
    {
        if (! self::tablesReady()) {
            return [];
        }

        return self::publishedQuery()
            ->when($category !== 'products', fn (Builder $query) => $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $category)))
            ->latest('published_at')
            ->latest()
            ->get()
            ->map(fn (Product $product) => self::present($product, $gender))
            ->all();
    }

    public static function related(array $product, int $limit = 4): array
    {
        if (! self::tablesReady()) {
            return [];
        }

        return self::publishedQuery()
            ->where('slug', '!=', $product['slug'])
            ->when($product['category'] !== 'products', fn (Builder $query) => $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $product['category'])))
            ->limit($limit)
            ->get()
            ->map(fn (Product $related) => self::present($related))
            ->all();
    }

    public static function featured(int $limit = 12): array
    {
        if (! self::tablesReady()) {
            return [];
        }

        $products = self::publishedQuery()
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->latest()
            ->limit($limit)
            ->get();

        return $products->map(fn (Product $product) => self::present($product))->all();
    }

    public static function facets(): array
    {
        if (! self::tablesReady()) {
            return [];
        }

        return Category::query()
            ->whereHas('products', fn (Builder $query) => $query->where('status', 'published'))
            ->withCount(['products' => fn (Builder $query) => $query->where('status', 'published')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (Category $category) => [
                'label' => $category->name,
                'href' => route('collections.show', ['gender' => 'all', 'category' => $category->slug]),
                'key' => 'all-'.$category->slug,
                'image' => $category->image_path,
                'count' => $category->products_count,
            ])
            ->values()
            ->all();
    }

    public static function money(int|float $amount): string
    {
        return '$'.number_format((float) $amount, 0);
    }

    private static function publishedQuery(): Builder
    {
        return Product::query()
            ->with(['category', 'images', 'variants'])
            ->where('status', 'published');
    }

    private static function present(Product $product, string $gender = 'all'): array
    {
        $images = $product->images->pluck('path')->filter()->values()->all();
        $variants = $product->variants->where('is_active', true);
        $material = $variants->pluck('material')->filter()->first();

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => (float) $product->price,
            'compareAtPrice' => $product->compare_at_price ? (float) $product->compare_at_price : null,
            'description' => $product->description ?: $product->short_description ?: '',
            'shortDescription' => $product->short_description ?: $product->description ?: '',
            'category' => $product->category?->slug ?? 'products',
            'categoryName' => $product->category?->name ?? 'Products',
            'gender' => $gender,
            'images' => count($images) ? $images : ['/images/products/hero-poster.jpg'],
            'colors' => $variants->pluck('color')->filter()->unique()->values()->all(),
            'sizes' => $variants->pluck('size')->filter()->unique()->values()->all(),
            'material' => $material ?: 'Premium composition',
            'care' => 'Follow the care guidance provided with your order.',
            'shippingNote' => 'Express delivery, boutique pickup, and eligible returns are available at checkout.',
            'tags' => $product->tags ?? [],
            'isNew' => $product->published_at?->greaterThanOrEqualTo(now()->subDays(30)) ?? false,
            'isBespokeEligible' => collect($product->tags ?? [])->contains(fn ($tag) => str($tag)->lower()->contains('bespoke')),
        ];
    }

    private static function tablesReady(): bool
    {
        return Schema::hasTable('products') && Schema::hasTable('categories');
    }
}

