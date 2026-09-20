<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'zona_id',
        'origen',
        'consentimiento',
        'capturado_por',
        'fecha_consentimiento',
        'consentimiento_verbal',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'consentimiento' => 'boolean',
            'consentimiento_verbal' => 'boolean',
            'fecha_consentimiento' => 'datetime',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    public function capturadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'capturado_por');
    }

    // ─── Accesores ─────────────────────────────────────

    public function getOrigenLabelAttribute(): string
    {
        return match ($this->origen) {
            'evento' => 'Evento',
            'qr' => 'QR',
            'whatsapp' => 'WhatsApp',
            'referido' => 'Referido',
            'otro' => 'Otro',
            default => ucfirst($this->origen),
        };
    }
}
