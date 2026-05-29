<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id','sku','size','color','material','price_modifier','stock','low_stock_threshold','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function product() { return $this->belongsTo(Product::class); }
    public function inventoryStocks() { return $this->hasMany(InventoryStock::class); }
    public function getIsLowStockAttribute(): bool { return $this->stock <= $this->low_stock_threshold; }
}
