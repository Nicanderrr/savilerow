<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model { protected $fillable = ['product_variant_id','warehouse_id','user_id','delta','type','note']; public function variant() { return $this->belongsTo(ProductVariant::class, 'product_variant_id'); } public function warehouse() { return $this->belongsTo(Warehouse::class); } public function user() { return $this->belongsTo(User::class); } }
