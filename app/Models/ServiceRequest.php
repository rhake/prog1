<?php

namespace App\Models;

use App\Support\ServiceChecklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id', 'vehicle_id', 'service_id', 'garage_id',
        'service_type', 'description', 'status', 'scheduled_date',
        'arrived_at', 'departed_at', 'provider_notes',
        'invoice_path', 'invoice_name',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'arrived_at' => 'datetime',
            'departed_at' => 'datetime',
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

    public function photos(): HasMany
    {
        return $this->hasMany(ServicePhoto::class);
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(ServiceChecklistItem::class)->orderBy('sort_order');
    }

    public function photosOf(string $kind)
    {
        return $this->photos->where('kind', $kind)->values();
    }

    public function invoiceUrl(): ?string
    {
        return $this->invoice_path ? asset($this->invoice_path) : null;
    }

    public function ensureChecklist(): void
    {
        if ($this->checklistItems()->exists()) {
            return;
        }

        foreach (ServiceChecklist::template() as $index => $item) {
            $this->checklistItems()->create([
                ...$item,
                'status' => 'pending',
                'sort_order' => $index,
            ]);
        }
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['pending', 'accepted', 'in_progress'], true);
    }
}
