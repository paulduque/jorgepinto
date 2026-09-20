<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fase',
        'semana_id',
        'responsable_id',
        'fecha_limite',
        'estado',
        'prioridad',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'fecha_limite' => 'date',
            'orden' => 'integer',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function semana(): BelongsTo
    {
        return $this->belongsTo(SemanaPlan::class, 'semana_id');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    // ─── Accesores ─────────────────────────────────────

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'pendiente' => 'Pendiente',
            'en_curso' => 'En curso',
            'completada' => 'Completada',
            'bloqueada' => 'Bloqueada',
            default => ucfirst($this->estado),
        };
    }

    public function getPrioridadLabelAttribute(): string
    {
        return match ($this->prioridad) {
            'alta' => 'Alta',
            'media' => 'Media',
            'baja' => 'Baja',
            default => ucfirst($this->prioridad),
        };
    }
}
