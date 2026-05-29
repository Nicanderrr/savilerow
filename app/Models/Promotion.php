<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model { protected $fillable = ['name','type','payload','starts_at','ends_at','is_active']; protected $casts = ['payload'=>'array','starts_at'=>'datetime','ends_at'=>'datetime','is_active'=>'boolean']; }
