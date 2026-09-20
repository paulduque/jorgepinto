<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PiezaContenido extends Model
{
    use HasFactory;

    protected $table = 'piezas_contenido';

    protected $fillable = [
        'fecha',
        'formato',
        'mensaje',
        'zona_id',
        'estado',
        'alcance',
        'interacciones',
        'url',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'alcance' => 'integer',
            'interacciones' => 'integer',
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
            'borrador' => 'Borrador',
            'aprobado' => 'Aprobado',
            'programado' => 'Programado',
            'publicado' => 'Publicado',
            default => ucfirst($this->estado),
        };
    }

    public function getTasaInteraccionAttribute(): float
    {
        if ($this->alcance === 0) {
            return 0;
        }
        return round(($this->interacciones / $this->alcance) * 100, 2);
    }
}
