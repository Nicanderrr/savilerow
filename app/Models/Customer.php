<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first_name','last_name','email','phone','status','loyalty_points','notes','banned_at'];
    protected $casts = ['banned_at' => 'datetime'];
    public function orders() { return $this->hasMany(Order::class); }
    public function addresses() { return $this->hasMany(CustomerAddress::class); }
    public function getNameAttribute(): string { return trim($this->first_name.' '.$this->last_name); }
}
