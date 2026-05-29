<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','order_number','status','payment_status','fulfillment_status','currency','subtotal','discount_total','tax_total','shipping_total','total','shipping_method','tracking_number','ip_address','country_code','country','region','city','latitude','longitude','placed_at'];
    protected $casts = ['placed_at' => 'datetime'];
    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function timeline() { return $this->hasMany(OrderTimeline::class)->latest(); }
}
