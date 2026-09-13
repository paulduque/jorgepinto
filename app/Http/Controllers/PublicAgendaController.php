<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicAgendaController extends Controller
{
    /**
     * Listado de eventos públicos.
     */
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('is_public', true)
            ->whereIn('status', ['planificado', 'en_curso'])
            ->with('assignedUsers');

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filtro por mes (opcional)
        if ($request->filled('month')) {
            $month = Carbon::parse($request->input('month'));
            $query->whereYear('start_at', $month->year)
                ->whereMonth('start_at', $month->month);
        }

        $events = $query
            ->orderBy('start_at', 'asc')
            ->paginate(12);

        // Eventos para el calendario (todos, sin paginar)
        $calendarEvents = Event::query()
            ->where('is_public', true)
            ->whereIn('status', ['planificado', 'en_curso'])
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_at->toIso8601String(),
                    'end' => $event->end_at?->toIso8601String(),
                    'url' => route('agenda.show', $event),
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
                ];
            });

        return view('public.agenda.index', compact('events', 'calendarEvents'));
    }

    /**
     * Detalle de un evento público.
     */
    public function show(Event $event)
    {
        // Solo eventos públicos y planificados/en curso
        if (! $event->is_public || ! in_array($event->status, ['planificado', 'en_curso'])) {
            abort(404);
        }

        // Eventos relacionados (mismo tipo)
        $related = Event::query()
            ->where('is_public', true)
            ->whereIn('status', ['planificado', 'en_curso'])
            ->where('id', '!=', $event->id)
            ->where('type', $event->type)
            ->orderBy('start_at', 'asc')
            ->limit(3)
            ->get();

        return view('public.agenda.show', compact('event', 'related'));
    }
}
