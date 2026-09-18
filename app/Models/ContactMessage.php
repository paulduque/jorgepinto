<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'consent_given',
        'consent_given_at',
        'status',
        'ip_address',
        'user_agent',
        'read_at',
    ];

    protected $casts = [
        'consent_given' => 'boolean',
        'consent_given_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Scope para mensajes nuevos.
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'nuevo');
    }

    /**
     * Marcar como leído.
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => 'leido',
            'read_at' => now(),
        ]);
    }
}
