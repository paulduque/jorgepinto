<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiSemanal extends Model
{
    use HasFactory;

    protected $table = 'kpis_semanales';

    protected $fillable = [
        'semana_id',
        'kpi',
        'valor',
        'meta',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'meta' => 'decimal:2',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function semana(): BelongsTo
    {
        return $this->belongsTo(SemanaPlan::class, 'semana_id');
    }

    // ─── Accesores ─────────────────────────────────────

    public function getCumplimientoAttribute(): ?float
    {
        if (! $this->meta || $this->meta == 0) {
            return null;
        }
        return round(($this->valor / $this->meta) * 100, 1);
    }
}
