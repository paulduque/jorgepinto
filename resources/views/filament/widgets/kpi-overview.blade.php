@php
    $kpis = $this->getKpis();
    $semana = $this->getSemanaActual();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    KPIs de la semana
                </h3>
                @if ($semana)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $semana->codigo }} · {{ $semana->fase }}
                    </p>
                @endif
            </div>

            @if ($semana)
                <x-filament::badge color="primary" size="lg">
                    {{ $semana->fecha_inicio?->format('d/m') }} - {{ $semana->fecha_fin?->format('d/m') }}
                </x-filament::badge>
            @endif
        </div>

        {{-- Grid de tarjetas --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
            @foreach ($kpis as $kpi)
                <div
                    class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-4 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    {{-- Ícono + Label --}}
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ $kpi['label'] }}
                            </p>
                        </div>
                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-{{ $kpi['color'] }}-100 text-{{ $kpi['color'] }}-600 dark:bg-{{ $kpi['color'] }}-900/30 dark:text-{{ $kpi['color'] }}-400">
                            <x-dynamic-component :component="$kpi['icon']" class="h-4 w-4" />
                        </div>
                    </div>

                    {{-- Meta fija --}}
                    <div class="mt-3">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                            Meta S{{ $semana->codigo === 'S1' ? '1' : substr($semana->codigo, 1) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ number_format($kpi['meta'], 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Valor + Progreso --}}
                    <div class="mt-3 border-t border-gray-100 pt-3 dark:border-gray-700">
                        <div class="flex items-baseline justify-between">
                            <p class="text-2xl font-black text-gray-900 dark:text-white">
                                {{ number_format($kpi['valor'], 0, ',', '.') }}
                            </p>
                            <p
                                class="text-xs font-bold text-{{ $kpi['color'] }}-600 dark:text-{{ $kpi['color'] }}-400">
                                {{ $kpi['cumplimiento'] }}%
                            </p>
                        </div>

                        <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-700">
                            <div class="h-full rounded-full bg-{{ $kpi['color'] }}-500 transition-all duration-500"
                                style="width: {{ min($kpi['cumplimiento'], 100) }}%"></div>
                        </div>
                    </div>

                    {{-- Botón registrar / ver --}}
                    <div class="mt-3 flex items-center justify-between text-xs">
                        @if ($kpi['registrado_hoy'])
                            <button type="button" wire:click="abrirModal({{ $kpi['id'] }})"
                                class="flex items-center gap-1 text-green-600 hover:underline dark:text-green-400">
                                ✓ Hoy: {{ number_format($kpi['avance_hoy'], 0, ',', '.') }}
                            </button>
                        @else
                            <button type="button" wire:click="abrirModal({{ $kpi['id'] }})"
                                class="flex items-center gap-1 text-{{ $kpi['color'] }}-600 hover:underline dark:text-{{ $kpi['color'] }}-400">
                                + Registrar hoy
                            </button>
                        @endif
                    </div>

                    {{-- Tooltip de justificación --}}
                    @if ($kpi['notas'])
                        <div class="mt-3 border-t border-gray-100 pt-3 dark:border-gray-700">
                            <details class="group">
                                <summary
                                    class="flex cursor-pointer items-center gap-1 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    <x-heroicon-o-information-circle class="h-3.5 w-3.5" />
                                    <span>Ver fuente</span>
                                </summary>
                                <p class="mt-2 text-[10px] leading-relaxed text-gray-500 dark:text-gray-400">
                                    {{ $kpi['notas'] }}
                                </p>
                            </details>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if (empty($kpis))
            <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center dark:border-gray-600">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay KPIs configurados para la semana actual.
                </p>
            </div>
        @endif
    </x-filament::section>

    {{-- Modal para registrar avance --}}
    @if ($modalAbierto)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" wire:click.self="cerrarModal">
            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl dark:bg-gray-800">
                {{-- Header --}}
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Registrar avance
                    </h3>
                    <x-filament::icon-button icon="heroicon-o-x-mark" color="gray" wire:click="cerrarModal" />
                </div>

                {{-- Formulario --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Fecha
                        </label>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ now()->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Avance del día
                        </label>
                        <input type="number" wire:model="avanceValor" min="0" step="1"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            placeholder="0">
                        @error('avanceValor')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Notas (opcional)
                        </label>
                        <textarea wire:model="avanceNotas" rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            placeholder="Contexto del avance..."></textarea>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="mt-6 flex justify-end gap-3">
                    <x-filament::button color="gray" wire:click="cerrarModal">
                        Cancelar
                    </x-filament::button>

                    <x-filament::button color="primary" wire:click="guardarAvance">
                        Guardar
                    </x-filament::button>
                </div>
            </div>
        </div>
    @endif
</x-filament-widgets::widget>
