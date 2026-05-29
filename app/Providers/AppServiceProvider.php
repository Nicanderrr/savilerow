<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));

            return Limit::perMinute(5)->by($email.'|'.$request->ip());
        });

        RateLimiter::for('passwords', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        View::composer('partials.header', function ($view) {
            $menu = Schema::hasTable('settings')
                ? Setting::where('group', 'themes')->where('key', 'menu_sidebar')->first()?->value ?? []
                : [];

            $view->with('menuSidebar', array_merge([
                'eyebrow' => 'Mayfair house',
                'title' => 'Savile Row',
                'description' => 'Tailoring, leather goods, and private service from the house.',
                'cta_label' => 'Shop new arrivals',
                'cta_url' => '/collections/all/products',
                'hero_image' => '/images/products/tailoring.jpg',
                'cards' => [
                    ['label' => 'Men tailoring', 'url' => '/collections/men/suits', 'image' => '/images/products/men-promo.jpg'],
                    ['label' => 'Women tailoring', 'url' => '/collections/women/suits', 'image' => '/images/products/blazer-w-1.jpg'],
                    ['label' => 'Leather goods', 'url' => '/collections/women/bags', 'image' => '/images/products/bag-promo.jpg'],
                ],
            ], $menu));
        });
    }
}
