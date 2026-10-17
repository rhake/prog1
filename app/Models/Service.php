<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'service_name', 'category', 'average_price', 'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'average_price' => 'decimal:2',
        ];
    }

    public function requests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
