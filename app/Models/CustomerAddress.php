<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = ['customer_id','type','line_one','line_two','city','region','postal_code','country','is_default'];
    protected $casts = ['is_default' => 'boolean'];
    public function customer() { return $this->belongsTo(Customer::class); }
}
