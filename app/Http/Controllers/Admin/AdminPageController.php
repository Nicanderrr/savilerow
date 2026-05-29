<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{AdminNotification, Banner, BlogPost, Category, Coupon, Customer, Order, Product, ProductVariant, Role, Setting, TrafficLog};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function categories()
    {
        return view('admin.categories.index', [
            'categories' => Category::with('parent')->orderBy('sort_order')->orderBy('name')->paginate(15),
            'parents' => Category::orderBy('name')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image_path'] = Storage::url($request->file('image')->store('categories', 'public'));
        }

        Category::create($data);

        return back()->with('success', 'Category created.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $this->validateCategory($request, $category);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ((int) ($data['parent_id'] ?? 0) === $category->id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        if ($request->hasFile('image')) {
            $this->deletePublicSettingFile($category->image_path);
            $data['image_path'] = Storage::url($request->file('image')->store('categories', 'public'));
        }

        $category->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->withErrors(['category' => 'Move or delete products in this category first.']);
        }

        $this->deletePublicSettingFile($category->image_path);
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
    public function brands() { return view('admin.crud-table', ['title' => 'Brands', 'description' => 'Fashion houses and supplier labels.', 'items' => \App\Models\Brand::paginate(15), 'columns' => ['name','slug','is_active']]); }
    public function inventory() { return view('admin.inventory', ['variants' => ProductVariant::with('product')->paginate(15)]); }
    public function orders(Request $request) { return view('admin.orders.index', ['orders' => Order::with('customer')->latest()->paginate(15)]); }
    public function orderShow(Order $order) { return view('admin.orders.show', ['order' => $order->load(['customer','items','timeline.user'])]); }
    public function returns() { return view('admin.simple-page', ['title' => 'Returns', 'description' => 'Refund and return authorizations.', 'metrics' => ['Pending returns' => 7, 'Approved refunds' => 3, 'Value at risk' => '$4,820']]); }
    public function invoices() { return view('admin.simple-page', ['title' => 'Invoices', 'description' => 'Invoice generation and printable receipts.', 'metrics' => ['Generated this month' => 38, 'Awaiting payment' => 4, 'Export queue' => 0]]); }
    public function customers() { return view('admin.customers.index', ['customers' => Customer::withCount('orders')->paginate(15)]); }
    public function analytics(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->query('start'))->startOfDay() : now()->subDays(29)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->query('end'))->endOfDay() : now()->endOfDay();

        $traffic = TrafficLog::query()
            ->whereBetween('visited_at', [$start, $end])
            ->when($request->country, fn ($query, $country) => $query->where('country', $country))
            ->when($request->device, fn ($query, $device) => $query->where('device_type', $device))
            ->when($request->path, fn ($query, $path) => $query->where('path', 'like', "%{$path}%"));

        $orders = Order::query()
            ->where('payment_status', 'paid')
            ->whereNotNull('placed_at')
            ->whereBetween('placed_at', [$start, $end])
            ->when($request->country, fn ($query, $country) => $query->where('country', $country));

        $trafficByDay = (clone $traffic)
            ->selectRaw("date(visited_at) as day, count(*) as visits, count(distinct ip_hash) as visitors")
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $countryTraffic = (clone $traffic)
            ->selectRaw("coalesce(country, 'Unknown') as country_name, count(*) as visits, count(distinct ip_hash) as visitors")
            ->groupBy('country_name')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();

        $orderOrigins = (clone $orders)
            ->selectRaw("coalesce(country, 'Unknown') as country_name, coalesce(region, 'Unknown') as region_name, count(*) as orders, sum(total) as revenue")
            ->groupBy('country_name', 'region_name')
            ->orderByDesc('revenue')
            ->limit(12)
            ->get();

        $topPages = (clone $traffic)
            ->selectRaw('path, count(*) as visits, count(distinct ip_hash) as visitors, avg(duration_ms) as avg_duration')
            ->groupBy('path')
            ->orderByDesc('visits')
            ->limit(12)
            ->get();

        return view('admin.analytics', [
            'filters' => [
                'start' => $start->toDateString(),
                'end' => $end->toDateString(),
                'country' => $request->country,
                'device' => $request->device,
                'path' => $request->path,
            ],
            'countries' => TrafficLog::query()->whereNotNull('country')->distinct()->orderBy('country')->pluck('country'),
            'stats' => [
                'visits' => (clone $traffic)->count(),
                'visitors' => (clone $traffic)->distinct('ip_hash')->count('ip_hash'),
                'orders' => (clone $orders)->count(),
                'revenue' => (clone $orders)->sum('total'),
            ],
            'trafficLabels' => $trafficByDay->pluck('day')->map(fn ($day) => now()->parse($day)->format('M j')),
            'trafficVisits' => $trafficByDay->pluck('visits'),
            'trafficVisitors' => $trafficByDay->pluck('visitors'),
            'countryTraffic' => $countryTraffic,
            'orderOrigins' => $orderOrigins,
            'topPages' => $topPages,
        ]);
    }
    public function promotions() { return view('admin.crud-table', ['title' => 'Coupons & Promotions', 'description' => 'Discounts, flash sales, and scheduled campaigns.', 'items' => Coupon::paginate(15), 'columns' => ['code','type','value','is_active','starts_at','ends_at']]); }
    public function cms(string $section = 'homepage') { return view('admin.cms', ['section' => $section, 'banners' => Banner::orderBy('sort_order')->get(), 'posts' => BlogPost::latest()->limit(8)->get()]); }
    public function notifications() { return view('admin.notifications', ['notifications' => AdminNotification::latest()->paginate(20)]); }
    public function clearNotifications()
    {
        AdminNotification::whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'Notifications cleared.');
    }
    public function clearNotification(AdminNotification $notification)
    {
        $notification->update(['read_at' => now()]);

        return back()->with('success', 'Notification cleared.');
    }
    public function staff() { return view('admin.staff', ['roles' => Role::withCount('users')->get(), 'users' => \App\Models\User::with('roles')->paginate(15)]); }
    public function reports() { return view('admin.simple-page', ['title' => 'Reports', 'description' => 'CSV/PDF exports for revenue, product performance, and customers.', 'metrics' => ['Revenue reports' => 12, 'Scheduled exports' => 5, 'Saved filters' => 9]]); }
    public function settings(string $section = 'general') { return view('admin.settings', ['section' => $section, 'settings' => Setting::where('group', $section)->get()->keyBy('key')]); }
    public function updateSettings(Request $request, string $section)
    {
        if ($section !== 'themes') {
            return back()->with('success', 'Settings saved.');
        }

        $validated = $request->validate([
            'hero_eyebrow' => ['nullable', 'string', 'max:120'],
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_button_label' => ['nullable', 'string', 'max:80'],
            'hero_button_url' => ['nullable', 'string', 'max:255'],
            'hero_media_type' => ['required', 'in:image,video'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'hero_video' => ['nullable', 'file', 'mimes:mp4,webm,mov', 'max:51200'],
            'sidebar_eyebrow' => ['nullable', 'string', 'max:120'],
            'sidebar_title' => ['required', 'string', 'max:120'],
            'sidebar_description' => ['nullable', 'string', 'max:220'],
            'sidebar_design' => ['required', 'in:modern,classic'],
            'sidebar_cta_label' => ['nullable', 'string', 'max:80'],
            'sidebar_cta_url' => ['nullable', 'string', 'max:255'],
            'sidebar_hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'sidebar_cards' => ['nullable', 'array', 'size:3'],
            'sidebar_cards.*.label' => ['required', 'string', 'max:80'],
            'sidebar_cards.*.url' => ['required', 'string', 'max:255'],
            'sidebar_card_images' => ['nullable', 'array'],
            'sidebar_card_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $hero = Setting::firstOrCreate(
            ['group' => 'themes', 'key' => 'home_hero'],
            ['value' => []]
        );

        $value = array_merge([
            'eyebrow' => 'New collection',
            'title' => 'Spring / Summer 2026',
            'button_label' => 'Discover',
            'button_url' => '/collections/all/products',
            'media_type' => 'video',
            'image' => '/images/products/hero-poster.jpg',
            'video' => '/video/hero1.mp4',
        ], $hero->value ?? []);

        if ($request->hasFile('hero_image')) {
            $this->deletePublicSettingFile($value['image'] ?? null);
            $value['image'] = Storage::url($request->file('hero_image')->store('themes/hero', 'public'));
        }

        if ($request->hasFile('hero_video')) {
            $this->deletePublicSettingFile($value['video'] ?? null);
            $value['video'] = Storage::url($request->file('hero_video')->store('themes/hero', 'public'));
        }

        $hero->update([
            'value' => array_merge($value, [
                'eyebrow' => $validated['hero_eyebrow'] ?: 'New collection',
                'title' => $validated['hero_title'],
                'button_label' => $validated['hero_button_label'] ?: 'Discover',
                'button_url' => $validated['hero_button_url'] ?: '/collections/all/products',
                'media_type' => $validated['hero_media_type'],
            ]),
        ]);

        $sidebar = Setting::firstOrCreate(
            ['group' => 'themes', 'key' => 'menu_sidebar'],
            ['value' => []]
        );

        $sidebarValue = array_merge([
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
        ], $sidebar->value ?? []);

        if ($request->hasFile('sidebar_hero_image')) {
            $this->deletePublicSettingFile($sidebarValue['hero_image'] ?? null);
            $sidebarValue['hero_image'] = Storage::url($request->file('sidebar_hero_image')->store('themes/sidebar', 'public'));
        }

        $cards = $sidebarValue['cards'];
        foreach ($validated['sidebar_cards'] ?? [] as $index => $card) {
            $cards[$index] = array_merge($cards[$index] ?? [], [
                'label' => $card['label'],
                'url' => $card['url'],
            ]);

            if ($request->hasFile("sidebar_card_images.$index")) {
                $this->deletePublicSettingFile($cards[$index]['image'] ?? null);
                $cards[$index]['image'] = Storage::url($request->file("sidebar_card_images.$index")->store('themes/sidebar/cards', 'public'));
            }
        }

        $sidebar->update([
            'value' => array_merge($sidebarValue, [
                'eyebrow' => $validated['sidebar_eyebrow'] ?: 'Mayfair house',
                'title' => $validated['sidebar_title'],
                'description' => $validated['sidebar_description'] ?: 'Tailoring, leather goods, and private service from the house.',
                'design' => $validated['sidebar_design'],
                'cta_label' => $validated['sidebar_cta_label'] ?: 'Shop new arrivals',
                'cta_url' => $validated['sidebar_cta_url'] ?: '/collections/all/products',
                'cards' => array_values($cards),
            ]),
        ]);

        return back()->with('success', 'Theme settings updated.');
    }
    public function profile() { return view('admin.profile'); }

    private function deletePublicSettingFile(?string $path): void
    {
        if (! $path || ! str_starts_with($path, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(str($path)->after('/storage/')->toString());
    }

    private function validateCategory(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'parent_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'.($category ? ','.$category->id : '')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
        ]);
    }
}
