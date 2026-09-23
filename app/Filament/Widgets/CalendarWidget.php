<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Filament\Resources\EventResource;
use Filament\Facades\Filament;
use App\Models\User;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 15;

    /**
     * Solo mostrar el widget si:
     * ...
     */
    public static function canView(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();

        if (! $user) {
            return false;
        }

        $user = \App\Models\User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->can('widget_CalendarWidget');
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('start_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_at->toIso8601String(),
                    'end' => $event->end_at?->toIso8601String(),
                    'url' => EventResource::getUrl('view', ['record' => $event]),
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
