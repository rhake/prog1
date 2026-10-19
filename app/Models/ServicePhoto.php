<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePhoto extends Model
{
    public const KINDS = ['service', 'entry', 'exit'];

    protected $fillable = [
        'service_request_id', 'kind', 'path', 'caption',
    ];

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function url(): string
    {
        return asset($this->path);
    }

    public function kindLabel(): string
    {
        return match ($this->kind) {
            'service' => 'Foto do serviço',
            'entry' => 'Foto de entrada',
            'exit' => 'Foto de saída',
            default => $this->kind,
        };
    }
}
