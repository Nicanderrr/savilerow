<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'ip_hash',
        'method',
        'path',
        'route_name',
        'status_code',
        'referer',
        'user_agent',
        'device_type',
        'country_code',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'duration_ms',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
}
