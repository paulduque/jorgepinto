<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'type',
        'start_at',
        'end_at',
        'all_day',
        'location',
        'address',
        'latitude',
        'longitude',
        'is_public',
        'status',
        'color',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'all_day' => 'boolean',
            'is_public' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    // ─────────────────────────────────────────────────────────
    // Eventos del modelo
    // ─────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saving(function (Event $event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . uniqid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ─────────────────────────────────────────────────────────
    // Relaciones
    // ─────────────────────────────────────────────────────────

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withPivot(['role_in_event', 'attendance_status'])
            ->withTimestamps();
    }

    // ─────────────────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────────────────

    public function scopeUpcoming($query)
    {
        return $query->where('start_at', '>=', now())
            ->orderBy('start_at');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ─────────────────────────────────────────────────────────
    // Accesores
    // ─────────────────────────────────────────────────────────

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'mitin' => 'Mitin',
            'reunion' => 'Reunión',
            'entrevista' => 'Entrevista',
            'gira' => 'Gira',
            'tarea' => 'Tarea',
            'otro' => 'Otro',
            default => ucfirst($this->type),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'planificado' => 'Planificado',
            'en_curso' => 'En curso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            default => ucfirst($this->status),
        };
    }
}
