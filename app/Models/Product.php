<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['brand_id','category_id','name','slug','sku','short_description','description','price','compare_at_price','status','is_featured','tags','seo_title','seo_description','published_at'];
    protected $casts = ['tags' => 'array', 'is_featured' => 'boolean', 'published_at' => 'datetime'];

    public function brand() { return $this->belongsTo(Brand::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function variants() { return $this->hasMany(ProductVariant::class); }
    public function images() { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function related() { return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id'); }
}
