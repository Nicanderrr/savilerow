<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LookbookItem extends Model { protected $fillable = ['title','image_path','product_ids','sort_order']; protected $casts = ['product_ids'=>'array']; }
