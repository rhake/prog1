<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_id', 'service_id', 'garage_id',
        'service_type', 'description', 'status', 'scheduled_date',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
        ];
    }

    public const STATUSES = [
        'pending', 'accepted', 'denied', 'in_progress', 'completed', 'cancelled',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class);
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['pending', 'accepted', 'in_progress'], true);
    }
}
