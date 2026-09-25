<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use HasFactory, HasSlug;

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
        'location_map',
        'is_public',
        'status',
        'color',
        'created_by',
    ];

    /**
     * Atributos computados que se incluyen en las respuestas JSON.
     * El atributo 'location_map' se calcula a partir de 'latitude' y 'longitude'
     * y es el que usa el paquete Filament Google Maps.
     *
     * NOTA: no usamos 'location' porque ya existe como columna física
     * en la tabla 'events' (nombre del lugar), y habría conflicto.
     */
    protected $appends = [
        'location_map',
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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // ─────────────────────────────────────────────────────────
    // Atributo computado: location_map (Filament Google Maps)
    // ─────────────────────────────────────────────────────────

    /**
     * Devuelve los atributos 'latitude' y 'longitude' como el atributo computado
     * 'location_map', en formato de array estándar de Google Maps con claves
     * 'lat' y 'lng'.
     *
     * Usado por el paquete Filament Google Maps.
     *
     * @return array
     */
    public function getLocationMapAttribute(): array
    {
        return [
            "lat" => (float) $this->latitude,
            "lng" => (float) $this->longitude,
        ];
    }

    /**
     * Toma un array de Google Maps con valores 'lat' y 'lng' y los asigna a los
     * atributos 'latitude' y 'longitude' del modelo.
     *
     * Usado por el paquete Filament Google Maps.
     *
     * @param ?array $location
     * @return void
     */
    public function setLocationMapAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['latitude'] = $location['lat'] ?? null;
            $this->attributes['longitude'] = $location['lng'] ?? null;
            unset($this->attributes['location_map']);
        }
    }

    /**
     * Devuelve los nombres de los atributos de latitud y longitud usados en esta tabla.
     *
     * Usado por el paquete Filament Google Maps.
     *
     * @return string[]
     */
    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }

    /**
     * Devuelve el nombre del atributo computado de ubicación.
     *
     * Usado por el paquete Filament Google Maps.
     *
     * @return string
     */
    public static function getComputedLocation(): string
    {
        return 'location_map';
    }
}
