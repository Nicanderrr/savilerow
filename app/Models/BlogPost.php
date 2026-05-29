<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model { protected $fillable = ['user_id','title','slug','body','image_path','status','published_at']; protected $casts = ['published_at'=>'datetime']; public function author() { return $this->belongsTo(User::class, 'user_id'); } }
