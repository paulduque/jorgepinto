<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    /**
     * Solo mostrar el widget si:
     * 1. Estamos en la página de calendario
     * 2. El usuario tiene rol super_admin o coordinador
     */
    public static function canView(): bool
    {
        // 1. Verificar que estamos en la página de calendario
        if (! request()->routeIs('filament.admin.pages.calendar')) {
            return false;
        }

        // 2. Verificar el rol del usuario
        $user = \Filament\Facades\Filament::auth()->user();

        if (! $user) {
            return false;
        }

        // Recargar el modelo desde la BD para asegurar que tiene HasRoles
        $user = \App\Models\User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->hasAnyRole(['super_admin', 'coordinador']);
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $user = Auth::user();
        $canEdit = false;

        if ($user instanceof \App\Models\User) {
            $canEdit = $user->can('update_event');
        }

        return Event::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('start_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Event $event) use ($canEdit) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_at->toIso8601String(),
                    'end' => $event->end_at?->toIso8601String(),
                    'url' => $canEdit
                        ? \App\Filament\Resources\EventResource::getUrl('edit', ['record' => $event])
                        : null,
                    'backgroundColor' => match ($event->type) {
                        'mitin' => '#dc2626',
                        'reunion' => '#2563eb',
                        'entrevista' => '#d97706',
                        'gira' => '#16a34a',
                        'tarea' => '#64748b',
                        'otro' => '#9333ea',
                        default => '#3b82f6',
                    },
                    'borderColor' => match ($event->type) {
                        'mitin' => '#dc2626',
                        'reunion' => '#2563eb',
                        'entrevista' => '#d97706',
                        'gira' => '#16a34a',
                        'tarea' => '#64748b',
                        'otro' => '#9333ea',
                        default => '#3b82f6',
                    },
                    'extendedProps' => [
                        'type' => $event->type_label,
                        'status' => $event->status_label,
                        'location' => $event->location,
                    ],
                ];
            })
            ->toArray();
    }
}
