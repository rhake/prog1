<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_id', 'name', 'unique_id', 'status', 'last_update',
        'latitude', 'longitude', 'speed', 'course', 'address',
    ];

    protected function casts(): array
    {
        return [
            'last_update' => 'datetime',
            'latitude' => 'float',
            'longitude' => 'float',
            'speed' => 'float',
            'course' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
