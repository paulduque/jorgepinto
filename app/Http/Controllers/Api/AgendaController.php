<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    /**
     * Crear un nuevo evento.
     * POST /api/agenda/crear
     */
    public function crear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'type' => 'nullable|in:mitin,reunion,entrevista,gira,tarea,otro',
            'status' => 'nullable|in:planificado,en_curso,completado,cancelado',
            'is_public' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['type'] = $data['type'] ?? 'reunion';
        $data['status'] = $data['status'] ?? 'planificado';
        $data['is_public'] = $data['is_public'] ?? false;
        $data['created_by'] = $data['created_by'] ?? $request->user()?->id ?? 1;

        $event = Event::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Evento creado correctamente',
            'event' => $this->formatEvent($event),
        ], 201);
    }

    /**
     * Consultar la agenda del día.
     * GET /api/agenda/hoy
     */
    public function hoy(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $events = Event::with('assignedUsers')
            ->whereDate('start_at', $date)
            ->orderBy('start_at')
            ->get();

        return response()->json([
            'success' => true,
            'date' => $date,
            'total' => $events->count(),
            'events' => $events->map(fn($event) => $this->formatEvent($event)),
        ]);
    }

    /**
     * Consultar próximos eventos.
     * GET /api/agenda/proximos
     */
    public function proximos(Request $request)
    {
        $limit = $request->input('limit', 10);

        $events = Event::with('assignedUsers')
            ->where('start_at', '>=', now())
            ->whereIn('status', ['planificado', 'en_curso'])
            ->orderBy('start_at')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'total' => $events->count(),
            'events' => $events->map(fn($event) => $this->formatEvent($event)),
        ]);
    }

    /**
     * Buscar eventos por título.
     * GET /api/agenda/buscar?q=titulo
     */
    public function buscar(Request $request)
    {
        $query = $request->input('q', '');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Debes proporcionar un término de búsqueda',
            ], 422);
        }

        $events = Event::with('assignedUsers')
            ->where('title', 'like', "%{$query}%")
            ->orderBy('start_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'query' => $query,
            'total' => $events->count(),
            'events' => $events->map(fn($event) => $this->formatEvent($event)),
        ]);
    }

    /**
     * Editar un evento.
     * PUT /api/agenda/editar/{id}
     */
    public function editar(Request $request, $id)
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Evento no encontrado',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'sometimes|date',
            'end_at' => 'nullable|date|after:start_at',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'type' => 'nullable|in:mitin,reunion,entrevista,gira,tarea,otro',
            'status' => 'nullable|in:planificado,en_curso,completado,cancelado',
            'is_public' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $event->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado correctamente',
            'event' => $this->formatEvent($event->fresh()),
        ]);
    }

    /**
     * Eliminar un evento.
     * DELETE /api/agenda/eliminar/{id}
     */
    public function eliminar($id)
    {
        $event = Event::find($id);

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Evento no encontrado',
            ], 404);
        }

        $titulo = $event->title;
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => "Evento '{$titulo}' eliminado correctamente",
        ]);
    }

    /**
     * Formatear evento para respuesta JSON.
     */
    private function formatEvent(Event $event): array
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'type' => $event->type,
            'type_label' => $event->type_label,
            'start_at' => $event->start_at->toIso8601String(),
            'start_at_formatted' => $event->start_at->translatedFormat('l, d \d\e F \d\e Y - H:i'),
            'end_at' => $event->end_at?->toIso8601String(),
            'location' => $event->location,
            'address' => $event->address,
            'status' => $event->status,
            'status_label' => $event->status_label,
            'is_public' => $event->is_public,
            'assigned_users' => $event->assignedUsers->pluck('name')->toArray(),
        ];
    }
}
