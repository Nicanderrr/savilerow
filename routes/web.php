<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:login');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email')->middleware('throttle:passwords');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::view('/verify-email', 'auth.verify-email')->middleware('auth')->name('verification.notice');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/products/{product}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
    Route::resource('products', ProductController::class);
    Route::get('/categories', [AdminPageController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminPageController::class, 'storeCategory'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminPageController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminPageController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/brands', [AdminPageController::class, 'brands'])->name('brands.index');
    Route::get('/inventory', [AdminPageController::class, 'inventory'])->name('inventory.index');
    Route::get('/orders', [AdminPageController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminPageController::class, 'orderShow'])->name('orders.show');
    Route::get('/returns', [AdminPageController::class, 'returns'])->name('returns.index');
    Route::get('/invoices', [AdminPageController::class, 'invoices'])->name('invoices.index');
    Route::get('/customers', [AdminPageController::class, 'customers'])->name('customers.index');
    Route::get('/analytics', [AdminPageController::class, 'analytics'])->name('analytics.index');
    Route::get('/promotions', [AdminPageController::class, 'promotions'])->name('promotions.index');
    Route::get('/cms/{section?}', [AdminPageController::class, 'cms'])->name('cms.index');
    Route::get('/notifications', [AdminPageController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/clear', [AdminPageController::class, 'clearNotifications'])->name('notifications.clear');
    Route::post('/notifications/{notification}/clear', [AdminPageController::class, 'clearNotification'])->name('notifications.clear-one');
    Route::get('/staff', [AdminPageController::class, 'staff'])->name('staff.index');
    Route::get('/reports', [AdminPageController::class, 'reports'])->name('reports.index');
    Route::get('/settings/{section?}', [AdminPageController::class, 'settings'])->name('settings.index');
    Route::post('/settings/{section}', [AdminPageController::class, 'updateSettings'])->name('settings.update');
    Route::get('/profile', [AdminPageController::class, 'profile'])->name('profile');
});

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/collections/all/products', [StorefrontController::class, 'allProducts'])->name('collections.all');
Route::get('/collections/{gender}/{category}', [StorefrontController::class, 'collection'])->whereIn('gender', ['all', 'men', 'women', 'kids'])->where('category', '[A-Za-z0-9\-]+')->name('collections.show');
Route::get('/products/{slug}', [StorefrontController::class, 'product'])->where('slug', '[A-Za-z0-9\-]+')->name('products.show');
Route::view('/cart', 'storefront.cart')->name('cart');
Route::view('/checkout', 'storefront.checkout')->name('checkout');
Route::post('/checkout/paystack', [CheckoutController::class, 'initializePaystack'])->name('checkout.paystack.initialize');
Route::get('/checkout/paystack/callback', [CheckoutController::class, 'paystackCallback'])->name('checkout.paystack.callback');
Route::view('/bespoke', 'storefront.bespoke')->name('bespoke');
Route::view('/appointments', 'storefront.appointments')->name('appointments');
Route::view('/boutique', 'storefront.boutique')->name('boutique');
Route::view('/market', 'storefront.market')->name('market');
Route::prefix('policies')->name('policies.')->group(function () { Route::view('/shipping', 'policies.shipping')->name('shipping'); Route::view('/returns', 'policies.returns')->name('returns'); Route::view('/faq', 'policies.faq')->name('faq'); });
Route::redirect('/home', '/');
Route::redirect('/index.php', '/');
Route::redirect('/public', '/');
Route::fallback(fn () => redirect()->route('collections.all'));
