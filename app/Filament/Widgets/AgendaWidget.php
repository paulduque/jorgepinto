<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class AgendaWidget extends Widget
{
    protected static string $view = 'filament.widgets.agenda-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    /**
     * Controla quién puede ver este widget.
     * Solo super_admin y coordinador.
     */
    public static function canView(): bool
    {
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

    /**
     * Pasa datos a la vista.
     */
    protected function getViewData(): array
    {
        $today = Carbon::today();

        // Eventos de hoy
        $todayEvents = Event::with('assignedUsers')
            ->whereDate('start_at', $today)
            ->orderBy('start_at')
            ->get();

        // Próximos eventos (si no hay hoy)
        $upcomingEvents = collect();
        if ($todayEvents->isEmpty()) {
            $upcomingEvents = Event::with('assignedUsers')
                ->where('start_at', '>', now())
                ->orderBy('start_at')
                ->limit(5)
                ->get();
        }

        return [
            'today' => $today,
            'todayEvents' => $todayEvents,
            'upcomingEvents' => $upcomingEvents,
            'totalToday' => $todayEvents->count(),
        ];
    }
}
