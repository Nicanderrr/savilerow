<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\{Brand, Category, Product};
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['brand','category','images'])
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%"))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(), 'brands' => Brand::orderBy('name')->get(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(ProductRequest $request, ProductService $service)
    {
        $product = Product::create($service->data($request->validated()));
        $service->storeImages($product, $request->file('images', []));

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product->load(['brand','category','variants','images'])]);
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', ['product' => $product->load('images'), 'brands' => Brand::orderBy('name')->get(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(ProductRequest $request, Product $product, ProductService $service)
    {
        $product->update($service->data($request->validated()));

        if ($request->filled('remove_images')) {
            $service->removeImages($product, $request->input('remove_images', []));
        }

        $service->storeImages($product, $request->file('images', []));

        return back()->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product archived.');
    }

    public function duplicate(Product $product, ProductService $service)
    {
        $copy = $service->duplicate($product->load(['variants','images']));
        return redirect()->route('admin.products.edit', $copy)->with('success', 'Product duplicated as draft.');
    }
}
