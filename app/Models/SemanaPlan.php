<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SemanaPlan extends Model
{
    use HasFactory;

    protected $table = 'semanas_plan';

    protected $fillable = [
        'codigo',
        'fecha_inicio',
        'fecha_fin',
        'fase',
        'objetivo',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'semana_id');
    }

    public function kpis(): HasMany
    {
        return $this->hasMany(KpiSemanal::class, 'semana_id');
    }

    // ─── Accesores ─────────────────────────────────────

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'pendiente' => 'Pendiente',
            'en_curso' => 'En curso',
            'completada' => 'Completada',
            default => ucfirst($this->estado),
        };
    }
}
