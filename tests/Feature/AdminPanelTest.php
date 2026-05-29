<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_admin_pages_render_for_super_admin(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@savilerow.test')->firstOrFail();

        $product = Product::firstOrFail();

        foreach (['/admin', '/admin/products', '/admin/products/create', "/admin/products/{$product->id}", "/admin/products/{$product->id}/edit", '/admin/orders', '/admin/customers', '/admin/settings'] as $path) {
            $this->actingAs($user)->get($path)->assertOk();
        }
    }
}
