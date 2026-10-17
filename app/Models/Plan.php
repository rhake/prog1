<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'plan_name', 'monthly_price', 'description', 'services_included', 'max_services_per_year',
    ];

    protected function casts(): array
    {
        return [
            'monthly_price' => 'decimal:2',
            'services_included' => 'array',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function isPopular(): bool
    {
        return $this->plan_name === 'Plus';
    }
}
