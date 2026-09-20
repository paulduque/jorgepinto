<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = [
        'canton',
        'parroquia',
        'prioridad',
        'notas',
    ];

    // ─── Relaciones ────────────────────────────────────

    public function contactos(): HasMany
    {
        return $this->hasMany(Contacto::class);
    }

    public function validadores(): HasMany
    {
        return $this->hasMany(Validador::class);
    }

    public function eventosCampana(): HasMany
    {
        return $this->hasMany(EventoCampana::class);
    }

    public function piezasContenido(): HasMany
    {
        return $this->hasMany(PiezaContenido::class);
    }

    // ─── Accesores ─────────────────────────────────────

    public function getNombreCompletoAttribute(): string
    {
        return $this->parroquia
            ? "{$this->parroquia}, {$this->canton}"
            : $this->canton;
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
