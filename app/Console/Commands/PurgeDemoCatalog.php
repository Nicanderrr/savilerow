<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class PurgeDemoCatalog extends Command
{
    protected $signature = 'app:purge-demo-catalog';

    protected $description = 'Remove the old static demo products and empty demo categories.';

    public function handle(): int
    {
        if (! Schema::hasTable('products') || ! Schema::hasTable('product_images')) {
            $this->warn('Catalog tables are not available yet.');

            return self::SUCCESS;
        }

        $demoProducts = Product::query()
            ->whereHas('images', fn ($query) => $query->where('path', 'like', '/images/products/%'))
            ->whereDoesntHave('images', fn ($query) => $query->where('path', 'not like', '/images/products/%'))
            ->withTrashed()
            ->get();

        $deletedProducts = $demoProducts->count();

        $demoProducts->each(function (Product $product) {
            $product->forceDelete();
        });

        $deletedCategories = 0;

        if (Schema::hasTable('categories')) {
            $deletedCategories = Category::query()
                ->whereDoesntHave('products')
                ->whereIn('slug', ['suits', 'shoes', 'bags', 'accessories', 'perfumes', 'kids'])
                ->delete();
        }

        $this->normalizeDemoThemeLinks();

        $this->info("Demo catalog purged: {$deletedProducts} products, {$deletedCategories} categories.");

        return self::SUCCESS;
    }

    private function normalizeDemoThemeLinks(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $oldRoutes = ['/collections/men/suits', '/collections/women/suits', '/collections/women/bags'];

        $hero = Setting::where('group', 'themes')->where('key', 'home_hero')->first();
        if ($hero && in_array($hero->value['button_url'] ?? null, $oldRoutes, true)) {
            $value = $hero->value ?: [];
            $value['button_url'] = '/collections/all/products';
            $hero->update(['value' => $value]);
        }

        $sidebar = Setting::where('group', 'themes')->where('key', 'menu_sidebar')->first();
        if (! $sidebar) {
            return;
        }

        $value = $sidebar->value ?: [];
        $cards = collect($value['cards'] ?? [])->map(function (array $card) use ($oldRoutes) {
            if (in_array($card['url'] ?? null, $oldRoutes, true)) {
                $card['url'] = '/collections/all/products';
            }

            return $card;
        })->values()->all();

        $value['cards'] = $cards;
        $sidebar->update(['value' => $value]);
    }
}
