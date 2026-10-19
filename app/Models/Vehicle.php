<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id', 'brand', 'model', 'year', 'plate', 'mileage', 'vin', 'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->ofMany(
            ['id' => 'max'],
            fn ($query) => $query->where('status', 'active'),
        );
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ServiceHistory::class)->latest('service_date');
    }

    public function device(): HasOne
    {
        return $this->hasOne(Device::class);
    }

    public function label(): string
    {
        return trim($this->brand.' '.$this->model);
    }
}
