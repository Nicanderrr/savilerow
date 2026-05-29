<?php

namespace Database\Seeders;

use App\Models\{AdminNotification, Brand, Category, Coupon, Customer, Order, OrderItem, Permission, Product, ProductImage, ProductVariant, Role, Setting, User, Warehouse};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect(['dashboard.view','products.manage','categories.manage','inventory.manage','orders.manage','customers.manage','promotions.manage','cms.manage','analytics.view','settings.manage','staff.manage','reports.view'])->mapWithKeys(fn ($name) => [$name => Permission::firstOrCreate(['name' => $name], ['label' => Str::headline($name)])]);

        $super = Role::firstOrCreate(['name' => 'super-admin'], ['label' => 'Super Admin']);
        $manager = Role::firstOrCreate(['name' => 'manager'], ['label' => 'Manager']);
        $staff = Role::firstOrCreate(['name' => 'staff'], ['label' => 'Staff']);
        $super->permissions()->sync($permissions->pluck('id'));
        $manager->permissions()->sync($permissions->except(['settings.manage','staff.manage'])->pluck('id'));
        $staff->permissions()->sync($permissions->only(['dashboard.view','orders.manage','customers.manage','inventory.manage'])->pluck('id'));

        $admin = User::updateOrCreate(['email' => 'admin@mail.com'], [
            'name' => 'Savile Row Admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::where('email', 'admin@savilerow.test')->delete();
        $admin->roles()->syncWithoutDetaching([$super->id]);

        $brand = Brand::firstOrCreate(['slug' => 'savile-row'], ['name' => 'Savile Row', 'is_active' => true]);
        $categories = collect(['Suits','Shoes','Bags','Accessories','Perfumes','Kids'])->mapWithKeys(fn ($name) => [Str::slug($name) => Category::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_featured' => true])]);
        $warehouse = Warehouse::firstOrCreate(['code' => 'MAYFAIR'], ['name' => 'Mayfair Flagship', 'country' => 'United Kingdom', 'city' => 'London']);

        $catalog = json_decode(file_get_contents(resource_path('data/catalog.json')), true);
        foreach (array_slice($catalog, 0, 24) as $item) {
            $category = $categories->get($item['category']) ?? $categories->first();
            $product = Product::updateOrCreate(['slug' => $item['slug']], [
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => $item['name'],
                'sku' => 'SR-'.strtoupper(Str::slug($item['slug'], '-')),
                'short_description' => Str::limit($item['description'], 150),
                'description' => $item['description'],
                'price' => $item['price'],
                'status' => $item['isNew'] ? 'published' : 'draft',
                'is_featured' => (bool) $item['isNew'],
                'tags' => $item['tags'] ?? [],
                'published_at' => $item['isNew'] ? now() : null,
            ]);
            foreach (array_slice($item['images'], 0, 4) as $sort => $image) {
                ProductImage::updateOrCreate(['product_id' => $product->id, 'path' => $image], ['alt_text' => $item['name'], 'sort_order' => $sort]);
            }
            $sizes = $item['sizes'] ?: ['OS'];
            $colors = $item['colors'] ?: ['Default'];
            foreach (array_slice($sizes, 0, 3) as $size) {
                foreach (array_slice($colors, 0, 2) as $color) {
                    ProductVariant::firstOrCreate([
                        'sku' => $product->sku.'-'.strtoupper(Str::slug($size.'-'.$color, '-')),
                    ], [
                        'product_id' => $product->id,
                        'size' => $size,
                        'color' => $color,
                        'material' => $item['material'],
                        'stock' => fake()->numberBetween(0, 80),
                        'low_stock_threshold' => 8,
                    ]);
                }
            }
        }

        foreach ([['Amelia','Hart'],['Theo','Sinclair'],['Maya','Chen'],['Noah','Brooks'],['Elena','Voss'],['Julian','Reed'],['Iris','Laurent'],['Miles','Grant']] as $index => [$first, $last]) {
            Customer::firstOrCreate(['email' => strtolower($first).'.'.strtolower($last).'@example.com'], [
                'first_name' => $first,
                'last_name' => $last,
                'phone' => '+44 20 7000 '.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'status' => 'active',
                'loyalty_points' => 120 * ($index + 1),
            ]);
        }

        Customer::query()->limit(8)->get()->each(function (Customer $customer, int $i) {
            $order = Order::firstOrCreate(['order_number' => 'SR-'.now()->format('ymd').'-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT)], [
                'customer_id' => $customer->id,
                'status' => collect(['pending','processing','shipped','completed'])->random(),
                'payment_status' => 'paid',
                'fulfillment_status' => collect(['unfulfilled','partial','fulfilled'])->random(),
                'currency' => 'USD',
                'subtotal' => 1200 + ($i * 340),
                'tax_total' => 0,
                'shipping_total' => $i % 2 ? 25 : 0,
                'total' => 1225 + ($i * 340),
                'placed_at' => now()->subDays($i),
            ]);
            $product = Product::query()->inRandomOrder()->first();
            if ($product && $order->items()->doesntExist()) {
                OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'product_name' => $product->name, 'sku' => $product->sku, 'quantity' => 1, 'unit_price' => $product->price, 'total' => $product->price]);
            }
        });

        Coupon::firstOrCreate(['code' => 'ROW10'], ['type' => 'percentage', 'value' => 10, 'is_active' => true, 'starts_at' => now(), 'ends_at' => now()->addMonth()]);
        Setting::updateOrCreate(['group' => 'store', 'key' => 'name'], ['value' => 'Savile Row']);
        AdminNotification::firstOrCreate(['title' => 'Low stock review required'], ['user_id' => $admin->id, 'type' => 'inventory', 'message' => 'Several variants are below threshold.', 'url' => '/admin/inventory']);
    }
}

