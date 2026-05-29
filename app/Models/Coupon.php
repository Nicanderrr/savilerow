<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model { protected $fillable = ['code','type','value','minimum_order_amount','usage_limit','used_count','starts_at','ends_at','is_active']; protected $casts = ['starts_at'=>'datetime','ends_at'=>'datetime','is_active'=>'boolean']; }
