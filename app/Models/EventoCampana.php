<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoCampana extends Model
{
    use HasFactory;

    protected $table = 'eventos_campana';

    protected $fillable = [
        'titulo',
        'fecha',
        'zona_id',
        'descripcion',
        'contactos_captados',
        'piezas_publicadas',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'contactos_captados' => 'integer',
            'piezas_publicadas' => 'integer',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    // ─── Accesores ─────────────────────────────────────

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'planificado' => 'Planificado',
            'realizado' => 'Realizado',
            'cancelado' => 'Cancelado',
            default => ucfirst($this->estado),
        };
    }
}
