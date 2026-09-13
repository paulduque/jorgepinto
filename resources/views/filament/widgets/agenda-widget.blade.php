<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">📅</span>
                    <span>Agenda de hoy</span>
                    @if ($totalToday > 0)
                        <span
                            class="ml-2 rounded-full bg-primary-100 px-2 py-0.5 text-xs font-semibold text-primary-700 dark:bg-primary-900 dark:text-primary-300">
                            {{ $totalToday }} {{ $totalToday === 1 ? 'evento' : 'eventos' }}
                        </span>
                    @endif
                </div>

                <a href="{{ \App\Filament\Resources\EventResource::getUrl('index') }}"
                    class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                    Ver agenda completa →
                </a>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            {{-- Mini calendario (izquierda) --}}
            <div class="md:col-span-1">
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                    {{-- Encabezado del mes --}}
                    <div class="mb-3 text-center">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            {{ $today->translatedFormat('F Y') }}
                        </p>
                    </div>

                    {{-- Días de la semana --}}
                    <div
                        class="mb-2 grid grid-cols-7 gap-1 text-center text-[10px] font-semibold uppercase text-gray-400">
                        <span>L</span>
                        <span>M</span>
                        <span>M</span>
                        <span>J</span>
                        <span>V</span>
                        <span>S</span>
                        <span>D</span>
                    </div>

                    {{-- Días del mes --}}
                    @php
                        $startOfMonth = $today->copy()->startOfMonth();
                        $endOfMonth = $today->copy()->endOfMonth();
                        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 = lunes, 7 = domingo
                        $daysInMonth = $endOfMonth->day;
                        $todayDay = $today->day;
                    @endphp

                    <div class="grid grid-cols-7 gap-1 text-center text-xs">
                        {{-- Días vacíos antes del inicio del mes --}}
                        @for ($i = 1; $i < $startDayOfWeek; $i++)
                            <span></span>
                        @endfor

                        {{-- Días del mes --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @if ($day === $todayDay)
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary-600 font-bold text-white">
                                    {{ $day }}
                                </span>
                            @else
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    {{ $day }}
                                </span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Lista de eventos (derecha) --}}
            <div class="md:col-span-2">
                @if ($todayEvents->isNotEmpty())
                    {{-- Eventos de hoy --}}
                    <div class="space-y-3">
                        @foreach ($todayEvents as $event)
                            <a href="{{ \App\Filament\Resources\EventResource::getUrl('edit', ['record' => $event]) }}"
                                class="group block rounded-lg border border-gray-200 bg-white p-4 transition hover:border-primary-300 hover:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:border-primary-600">
                                <div class="flex items-start gap-4">
                                    {{-- Hora --}}
                                    <div
                                        class="flex flex-col items-center rounded-lg bg-primary-50 px-3 py-2 dark:bg-primary-900/30">
                                        <span class="text-lg font-bold text-primary-700 dark:text-primary-300">
                                            {{ $event->start_at->format('H:i') }}
                                        </span>
                                        @if ($event->end_at)
                                            <span
                                                class="text-[10px] font-medium text-primary-600 dark:text-primary-400">
                                                {{ $event->end_at->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Detalles --}}
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-start justify-between gap-2">
                                            <h4
                                                class="font-semibold text-gray-900 group-hover:text-primary-600 dark:text-white">
                                                {{ $event->title }}
                                            </h4>
                                            <span
                                                class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase
                                                @switch($event->status)
                                                    @case('planificado') bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 @break
                                                    @case('en_curso') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 @break
                                                    @case('completado') bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 @break
                                                    @case('cancelado') bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 @break
                                                @endswitch">
                                                {{ $event->status_label }}
                                            </span>
                                        </div>

                                        @if ($event->description)
                                            <p class="mt-1 line-clamp-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $event->description }}
                                            </p>
                                        @endif

                                        <div
                                            class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                            @if ($event->location)
                                                <span class="flex items-center gap-1">
                                                    📍 {{ $event->location }}
                                                </span>
                                            @endif

                                            @if ($event->assignedUsers->isNotEmpty())
                                                <span class="flex items-center gap-1">
                                                    👥 {{ $event->assignedUsers->pluck('name')->join(', ') }}
                                                </span>
                                            @endif

                                            <span class="rounded bg-gray-100 px-2 py-0.5 font-medium dark:bg-gray-700">
                                                {{ $event->type_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @elseif ($upcomingEvents->isNotEmpty())
                    {{-- Próximos eventos --}}
                    <div class="mb-3 flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Próximos eventos
                        </span>
                        <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                    </div>

                    <div class="space-y-3">
                        @foreach ($upcomingEvents as $event)
                            <a href="{{ \App\Filament\Resources\EventResource::getUrl('edit', ['record' => $event]) }}"
                                class="group block rounded-lg border border-gray-200 bg-white p-4 transition hover:border-primary-300 hover:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:border-primary-600">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex flex-col items-center rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-700">
                                        <span class="text-[10px] font-bold uppercase text-gray-500 dark:text-gray-400">
                                            {{ $event->start_at->translatedFormat('M') }}
                                        </span>
                                        <span class="text-lg font-bold text-gray-700 dark:text-gray-200">
                                            {{ $event->start_at->format('d') }}
                                        </span>
                                        <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400">
                                            {{ $event->start_at->format('H:i') }}
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4
                                            class="font-semibold text-gray-900 group-hover:text-primary-600 dark:text-white">
                                            {{ $event->title }}
                                        </h4>
                                        @if ($event->location)
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                📍 {{ $event->location }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Sin eventos --}}
                    <div
                        class="flex h-full min-h-[200px] flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-200 p-8 text-center dark:border-gray-700">
                        <div class="text-4xl">📭</div>
                        <p class="mt-3 font-semibold text-gray-700 dark:text-gray-300">
                            No hay eventos para hoy
                        </p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            La agenda está libre
                        </p>
                        <a href="{{ \App\Filament\Resources\EventResource::getUrl('create') }}"
                            class="mt-4 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-700">
                            + Crear evento
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
