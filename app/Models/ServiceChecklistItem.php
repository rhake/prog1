<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceChecklistItem extends Model
{
    public const STATUSES = ['pending', 'ok', 'damaged', 'missing', 'na'];

    protected $fillable = [
        'service_request_id', 'code', 'area', 'label', 'status', 'notes', 'sort_order',
    ];

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Não conferido',
            'ok' => 'Inteiro',
            'damaged' => 'Avaria',
            'missing' => 'Ausente',
            'na' => 'Não se aplica',
            default => $this->status,
        };
    }

    public function statusTone(): string
    {
        return match ($this->status) {
            'ok' => 'ok',
            'damaged' => 'danger',
            'missing' => 'warn',
            'na' => 'muted',
            default => 'info',
        };
    }
}
