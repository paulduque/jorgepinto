@extends('layouts.app')

@section('title', 'Agenda - Jorge Pinto')

@section('content')

    {{-- Hero de la agenda --}}
    <section class="relative min-h-[calc(100vh-5rem)] overflow-hidden bg-slate-950">
        @php
            $settings = \App\Models\SiteSetting::current();
            // 1. Imagen propia de la agenda (prioridad)
            // 2. Fallback: imagen del próximo evento público
            $heroImage =
                $settings?->agenda_image ??
                \App\Models\Event::where('is_public', true)->whereNotNull('image')->orderBy('start_at', 'asc')->first()
                    ?->image;
        @endphp

        @if ($heroImage)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $heroImage) }}" alt="Agenda de campaña" class="h-full w-full object-cover">
            </div>
        @endif

        {{-- Capas de contraste (idénticas al hero principal) --}}
        <div class="absolute inset-0 bg-slate-950/10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/20 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/10"></div>

        {{-- Contenido --}}
        <div class="relative mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl items-end px-6 pb-16 pt-24 md:pb-24">
            <div class="max-w-4xl text-white">
                <div class="flex items-center gap-4">
                    <span class="h-1 w-12 bg-blue-400"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-300 md:text-sm">
                        Agenda de campaña
                    </p>
                </div>

                <h1 class="mt-6 text-5xl font-black leading-[0.95] tracking-[-0.03em] md:text-7xl lg:text-8xl">
                    Próximos eventos
                </h1>

                <p class="mt-8 max-w-2xl text-base leading-7 text-slate-200 md:text-xl md:leading-8">
                    Acompáñanos en las actividades de nuestra campaña. Todos los eventos públicos de Jorge Pinto.
                </p>
            </div>
        </div>
    </section>

    {{-- Filtros --}}
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-6">
            <form method="GET" action="{{ route('agenda.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('agenda.index') }}"
                        class="rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wide transition
                        {{ !request('type') ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Todos
                    </a>
                    @foreach (['mitin' => 'Mitin', 'reunion' => 'Reunión', 'entrevista' => 'Entrevista', 'gira' => 'Gira', 'tarea' => 'Tarea'] as $key => $label)
                        <a href="{{ route('agenda.index', ['type' => $key]) }}"
                            class="rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wide transition
                            {{ request('type') === $key ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
    </section>

    {{-- Contenido principal --}}
    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-10 lg:grid-cols-3">

                {{-- Listado de eventos --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl font-black text-slate-950">Listado de eventos</h2>
                        <span class="h-px flex-1 bg-slate-300"></span>
                    </div>

                    @if ($events->isNotEmpty())
                        <div class="mt-6 space-y-4">
                            @foreach ($events as $event)
                                @include('public.agenda.partials.event-card', ['event' => $event])
                            @endforeach
                        </div>

                        {{-- Paginación --}}
                        <div class="mt-8">
                            {{ $events->links() }}
                        </div>
                    @else
                        <div class="mt-6 rounded-xl border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                            <div class="text-5xl">📭</div>
                            <p class="mt-4 text-lg font-semibold text-slate-700">
                                No hay eventos próximos
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                Vuelve pronto para ver las próximas actividades.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Mini calendario lateral --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="flex items-center gap-4">
                            <h3 class="text-lg font-black text-slate-950">Calendario</h3>
                            <span class="h-px flex-1 bg-slate-300"></span>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white p-4">
                            <div id="public-calendar"></div>
                        </div>

                        {{-- Leyenda --}}
                        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                Leyenda
                            </p>
                            <div class="mt-3 space-y-2 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #dc2626;"></span>
                                    <span class="text-slate-600">Mitin</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #2563eb;"></span>
                                    <span class="text-slate-600">Reunión</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #d97706;"></span>
                                    <span class="text-slate-600">Entrevista</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #16a34a;"></span>
                                    <span class="text-slate-600">Gira</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #64748b;"></span>
                                    <span class="text-slate-600">Tarea</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded-full" style="background-color: #9333ea;"></span>
                                    <span class="text-slate-600">Otro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FullCalendar --}}
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('public-calendar');
                if (!calendarEl) return;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today'
                    },
                    buttonText: {
                        today: 'Hoy'
                    },
                    events: @json($calendarEvents),
                    eventClick: function(info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault();
                            window.location.href = info.event.url;
                        }
                    },
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }
                });

                calendar.render();
            });
        </script>
    @endpush

@endsection
