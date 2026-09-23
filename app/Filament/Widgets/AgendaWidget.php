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
     * Estado del componente (Livewire).
     */
    public int $currentMonth;
    public int $currentYear;
    public string $selectedDate;

    /**
     * Inicializar el widget.
     */
    public function mount(): void
    {
        $today = Carbon::today();
        $this->currentMonth = $today->month;
        $this->currentYear = $today->year;
        $this->selectedDate = $today->format('Y-m-d');
    }

    /**
     * Seleccionar un día del calendario.
     */
    public function selectDay(int $day): void
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)
            ->format('Y-m-d');
    }

    /**
     * Ir al mes anterior.
     */
    public function previousMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    /**
     * Ir al mes siguiente.
     */
    public function nextMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

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

        $user = \App\Models\User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->can('widget_AgendaWidget');
    }

    /**
     * Datos para la vista.
     */
    protected function getViewData(): array
    {
        // Rango del mes actual
        $currentDate = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Eventos del mes (con margen de 7 días antes/después)
        $monthEvents = Event::with('assignedUsers')
            ->where('start_at', '>=', $startOfMonth->copy()->subDays(7))
            ->where('start_at', '<=', $endOfMonth->copy()->addDays(7))
            ->orderBy('start_at')
            ->get();

        // Agrupar eventos por día (Y-m-d)
        $eventsByDay = $monthEvents->groupBy(function ($event) {
            return $event->start_at->format('Y-m-d');
        });

        // Eventos del día seleccionado
        $selectedEvents = $eventsByDay->get($this->selectedDate, collect());

        // Info del calendario
        $startDayOfWeek = $startOfMonth->dayOfWeekIso;
        $daysInMonth = $endOfMonth->day;

        return [
            'currentMonthLabel' => $currentDate->translatedFormat('F Y'),
            'startDayOfWeek' => $startDayOfWeek,
            'daysInMonth' => $daysInMonth,
            'eventsByDay' => $eventsByDay,
            'selectedEvents' => $selectedEvents,
            'selectedDateLabel' => Carbon::parse($this->selectedDate)->translatedFormat('l, d \d\e F \d\e Y'),
            'totalSelected' => $selectedEvents->count(),
        ];
    }
}
