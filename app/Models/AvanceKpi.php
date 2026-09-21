<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvanceKpi extends Model
{
    use HasFactory;

    protected $table = 'avances_kpi';

    protected $fillable = [
        'kpi_semanal_id',
        'fecha',
        'valor',
        'notas',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'valor' => 'decimal:2',
        ];
    }

    // ─────────────────────────────────────────────────────────
    // Relaciones
    // ─────────────────────────────────────────────────────────

    public function kpiSemanal(): BelongsTo
    {
        return $this->belongsTo(KpiSemanal::class, 'kpi_semanal_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
