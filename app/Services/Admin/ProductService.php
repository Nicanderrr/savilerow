<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function data(array $validated): array
    {
        unset($validated['images'], $validated['remove_images']);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);
        $sku = $validated['sku'] ?: 'SR-'.strtoupper(Str::random(8));

        return array_merge($validated, [
            'slug' => $slug,
            'sku' => $sku,
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'tags' => collect(explode(',', $validated['tags'] ?? ''))->map(fn ($tag) => trim($tag))->filter()->values()->all(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);
    }

    public function storeImages(Product $product, array $images): void
    {
        $nextSort = (int) $product->images()->max('sort_order') + 1;

        foreach ($images as $image) {
            if (! $image instanceof UploadedFile) {
                continue;
            }

            $path = $image->store('products/'.$product->id, 'public');

            $product->images()->create([
                'path' => Storage::url($path),
                'alt_text' => $product->name,
                'sort_order' => $nextSort++,
            ]);
        }
    }

    public function removeImages(Product $product, array $imageIds): void
    {
        $product->images()
            ->whereIn('id', $imageIds)
            ->get()
            ->each(function ($image) {
                $storagePath = Str::after($image->path, '/storage/');

                if ($storagePath !== $image->path) {
                    Storage::disk('public')->delete($storagePath);
                }

                $image->delete();
            });
    }

    public function duplicate(Product $product): Product
    {
        $copy = $product->replicate(['slug', 'sku', 'status', 'published_at']);
        $copy->name = $product->name.' Copy';
        $copy->slug = Str::slug($copy->name).'-'.Str::lower(Str::random(4));
        $copy->sku = 'SR-'.strtoupper(Str::random(8));
        $copy->status = 'draft';
        $copy->published_at = null;
        $copy->save();

        foreach ($product->variants as $variant) {
            $newVariant = $variant->replicate(['sku']);
            $newVariant->product_id = $copy->id;
            $newVariant->sku = $copy->sku.'-'.Str::upper(Str::random(4));
            $newVariant->save();
        }

        foreach ($product->images as $image) {
            $newImage = $image->replicate();
            $newImage->product_id = $copy->id;
            $newImage->save();
        }

        return $copy;
    }
}
