<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model { protected $fillable = ['name','code','country','city']; public function stocks() { return $this->hasMany(InventoryStock::class); } }
