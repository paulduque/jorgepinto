<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;

    protected $table = 'incidentes';

    protected $fillable = [
        'fecha',
        'tipo',
        'descripcion',
        'respuesta',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    // ─── Accesores ─────────────────────────────────────

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'ataque' => 'Ataque',
            'desinformacion' => 'Desinformación',
            'crisis' => 'Crisis',
            'otro' => 'Otro',
            default => ucfirst($this->tipo),
        };
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'abierto' => 'Abierto',
            'en_proceso' => 'En proceso',
            'resuelto' => 'Resuelto',
            default => ucfirst($this->estado),
        };
    }
}
