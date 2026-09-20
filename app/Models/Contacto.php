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
        'fecha_consentimiento',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'consentimiento' => 'boolean',
            'fecha_consentimiento' => 'datetime',
        ];
    }

    // ─── Relaciones ────────────────────────────────────

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
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
