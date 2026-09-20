<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Validador extends Model
{
    use HasFactory;

    protected $table = 'validadores';

    protected $fillable = [
        'nombre',
        'cargo',
        'telefono',
        'zona_id',
        'estado',
        'fecha_apoyo',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_apoyo' => 'date',
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
            'contactado' => 'Contactado',
            'comprometido' => 'Comprometido',
            'activo' => 'Activo',
            'inactivo' => 'Inactivo',
            default => ucfirst($this->estado),
        };
    }
}
