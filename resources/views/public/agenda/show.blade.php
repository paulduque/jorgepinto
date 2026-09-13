@extends('layouts.app')

@section('title', $event->title . ' - Agenda - Jorge Pinto')

@section('content')

    {{-- Hero del evento --}}
    <section class="relative min-h-[calc(100vh-5rem)] overflow-hidden bg-slate-950">
        {{-- Imagen de fondo --}}
        @if ($event->image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                    class="h-full w-full object-cover">
            </div>
        @endif

        {{-- Capas de contraste (idénticas al hero principal) --}}
        <div class="absolute inset-0 bg-slate-950/10"></div>

        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/20 to-transparent"></div>

        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/10"></div>

        {{-- Contenido --}}
        <div class="relative mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl items-end px-6 pb-16 pt-24 md:pb-24">
            <div class="max-w-4xl text-white">
                {{-- Breadcrumb --}}
                <nav class="mb-6 flex items-center gap-2 text-xs text-slate-300">
                    <a href="/" class="hover:text-white">Inicio</a>
                    <span>/</span>
                    <a href="{{ route('agenda.index') }}" class="hover:text-white">Agenda</a>
                    <span>/</span>
                    <span class="text-white">{{ $event->title }}</span>
                </nav>

                {{-- Tipo --}}
                <div class="flex items-center gap-4">
                    <span class="h-1 w-12 bg-blue-400"></span>
                    <span
                        class="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider
                    @switch($event->type)
                        @case('mitin') bg-red-500/20 text-red-300 @break
                        @case('reunion') bg-blue-500/20 text-blue-300 @break
                        @case('entrevista') bg-amber-500/20 text-amber-300 @break
                        @case('gira') bg-green-500/20 text-green-300 @break
                        @case('tarea') bg-slate-500/20 text-slate-300 @break
                        @default bg-purple-500/20 text-purple-300
                    @endswitch">
                        {{ $event->type_label }}
                    </span>
                </div>

                <h1 class="mt-6 text-5xl font-black leading-[0.95] tracking-[-0.03em] md:text-6xl lg:text-7xl">
                    {{ $event->title }}
                </h1>

                {{-- Fecha y lugar --}}
                <div class="mt-8 flex flex-wrap items-center gap-6 text-sm text-slate-200 md:text-base">
                    <span class="flex items-center gap-2">
                        📅 {{ $event->start_at->translatedFormat('l, d \d\e F \d\e Y') }}
                    </span>
                    <span class="flex items-center gap-2">
                        🕐 {{ $event->start_at->format('H:i') }}
                        @if ($event->end_at)
                            - {{ $event->end_at->format('H:i') }}
                        @endif
                    </span>
                    @if ($event->location)
                        <span class="flex items-center gap-2">
                            📍 {{ $event->location }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-10 lg:grid-cols-3">
                {{-- Descripción --}}
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-black text-slate-950">Descripción</h2>
                    <span class="mt-2 block h-1 w-16 bg-blue-600"></span>

                    <div class="prose prose-slate mt-6 max-w-none">
                        @if ($event->description)
                            {!! nl2br(e($event->description)) !!}
                        @else
                            <p class="text-slate-500 italic">Sin descripción disponible.</p>
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        {{-- Info del evento --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                                Detalles
                            </h3>

                            <dl class="mt-4 space-y-4 text-sm">
                                <div>
                                    <dt class="font-semibold text-slate-700">Fecha</dt>
                                    <dd class="text-slate-600">
                                        {{ $event->start_at->translatedFormat('d \d\e F \d\e Y') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-slate-700">Hora</dt>
                                    <dd class="text-slate-600">
                                        {{ $event->start_at->format('H:i') }}
                                        @if ($event->end_at)
                                            - {{ $event->end_at->format('H:i') }}
                                        @endif
                                    </dd>
                                </div>
                                @if ($event->location)
                                    <div>
                                        <dt class="font-semibold text-slate-700">Lugar</dt>
                                        <dd class="text-slate-600">{{ $event->location }}</dd>
                                    </div>
                                @endif
                                @if ($event->address)
                                    <div>
                                        <dt class="font-semibold text-slate-700">Dirección</dt>
                                        <dd class="text-slate-600">{{ $event->address }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="font-semibold text-slate-700">Estado</dt>
                                    <dd>
                                        <span
                                            class="inline-block rounded-full px-2 py-0.5 text-xs font-semibold
                                            @switch($event->status)
                                                @case('planificado') bg-blue-100 text-blue-700 @break
                                                @case('en_curso') bg-amber-100 text-amber-700 @break
                                                @default bg-slate-100 text-slate-700
                                            @endswitch">
                                            {{ $event->status_label }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Responsables --}}
                        @if ($event->assignedUsers->isNotEmpty())
                            <div class="rounded-xl border border-slate-200 bg-white p-6">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">
                                    Asistentes
                                </h3>
                                <div class="mt-4 space-y-3">
                                    @foreach ($event->assignedUsers as $user)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">
                                                    {{ $user->name }}
                                                </p>
                                                @if ($user->position)
                                                    <p class="text-xs text-slate-500">
                                                        {{ $user->position }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Botón volver --}}
                        <a href="{{ route('agenda.index') }}"
                            class="block rounded-lg border border-slate-300 bg-white px-4 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            ← Volver a la agenda
                        </a>
                    </div>
                </div>
            </div>

            {{-- Eventos relacionados --}}
            @if ($related->isNotEmpty())
                <div class="mt-20">
                    <h2 class="text-2xl font-black text-slate-950">Otros eventos similares</h2>
                    <span class="mt-2 block h-1 w-16 bg-blue-600"></span>

                    <div class="mt-8 grid gap-6 md:grid-cols-3">
                        @foreach ($related as $relatedEvent)
                            @include('public.agenda.partials.event-card', ['event' => $relatedEvent])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
