<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">📅</span>
                    <span>Agenda del mes</span>
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

                    {{-- Navegación de mes --}}
                    <div class="mb-3 flex items-center justify-between">
                        <button type="button" wire:click="previousMonth"
                            class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 dark:hover:bg-gray-700">
                            ←
                        </button>

                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            {{ $currentMonthLabel }}
                        </p>

                        <button type="button" wire:click="nextMonth"
                            class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 dark:hover:bg-gray-700">
                            →
                        </button>
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
                    <div class="grid grid-cols-7 gap-1 text-center text-xs">
                        @for ($i = 1; $i < $startDayOfWeek; $i++)
                            <span></span>
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                                $isSelected = $date === $selectedDate;
                                $hasEvents = $eventsByDay->has($date) && $eventsByDay->get($date)->count() > 0;
                            @endphp

                            <button type="button" wire:click="selectDay({{ $day }})"
                                wire:key="day-{{ $currentYear }}-{{ $currentMonth }}-{{ $day }}"
                                class="relative flex h-7 w-7 items-center justify-center rounded-full transition
                                    @if ($isSelected) bg-primary-600 font-bold text-white
                                    @elseif ($hasEvents)
                                        bg-primary-100 font-semibold text-primary-700 hover:bg-primary-200 dark:bg-primary-900/40 dark:text-primary-300
                                    @else
                                        text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 @endif">
                                {{ $day }}
                                @if ($hasEvents && !$isSelected)
                                    <span class="absolute bottom-0.5 h-1 w-1 rounded-full bg-primary-600"></span>
                                @endif
                            </button>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Lista de eventos (derecha) --}}
            <div class="md:col-span-2">
                <div class="mb-3 flex items-center gap-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        {{ $selectedDateLabel }}
                    </span>
                    <span class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $totalSelected }} {{ $totalSelected === 1 ? 'evento' : 'eventos' }}
                    </span>
                </div>

                @if ($selectedEvents->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($selectedEvents as $event)
                            @php
                                $url = \App\Filament\Resources\EventResource::getUrl('view', ['record' => $event]);
                            @endphp

                            @if ($url)
                                <a href="{{ $url }}"
                                    class="group block rounded-lg border border-gray-200 bg-white p-4 transition hover:border-primary-300 hover:shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:hover:border-primary-600">
                                @else
                                    <div
                                        class="group relative block rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                            @endif

                            <div class="flex items-start gap-4">
                                <div
                                    class="flex flex-col items-center rounded-lg bg-primary-50 px-3 py-2 dark:bg-primary-900/30">
                                    <span class="text-lg font-bold text-primary-700 dark:text-primary-300">
                                        {{ $event->start_at->format('H:i') }}
                                    </span>
                                    @if ($event->end_at)
                                        <span class="text-[10px] font-medium text-primary-600 dark:text-primary-400">
                                            {{ $event->end_at->format('H:i') }}
                                        </span>
                                    @endif
                                </div>

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

                            @if ($url)
                                </a>
                            @else
                    </div>
                @endif
                @endforeach
            </div>
        @else
            <div
                class="flex h-full min-h-[200px] flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-200 p-8 text-center dark:border-gray-700">
                <div class="text-4xl">📭</div>
                <p class="mt-3 font-semibold text-gray-700 dark:text-gray-300">
                    No hay eventos para este día
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Selecciona otro día en el calendario
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
