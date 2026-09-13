<a href="{{ route('agenda.show', $event) }}"
    class="group block overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:border-blue-300 hover:shadow-lg">

    {{-- Imagen --}}
    @if ($event->image)
        <div class="aspect-[16/9] overflow-hidden">
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        </div>
    @endif

    <div class="flex items-stretch">
        {{-- Fecha --}}
        <div class="flex flex-col items-center justify-center bg-slate-950 px-6 py-6 text-white">
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-300">
                {{ $event->start_at->translatedFormat('M') }}
            </span>
            <span class="text-3xl font-black">
                {{ $event->start_at->format('d') }}
            </span>
            <span class="text-[10px] font-medium text-slate-400">
                {{ $event->start_at->translatedFormat('D') }}
            </span>
        </div>

        {{-- Detalles --}}
        <div class="flex-1 p-6">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <span
                        class="inline-block rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider
                        @switch($event->type)
                            @case('mitin') bg-red-100 text-red-700 @break
                            @case('reunion') bg-blue-100 text-blue-700 @break
                            @case('entrevista') bg-amber-100 text-amber-700 @break
                            @case('gira') bg-green-100 text-green-700 @break
                            @case('tarea') bg-slate-100 text-slate-700 @break
                            @default bg-purple-100 text-purple-700
                        @endswitch">
                        {{ $event->type_label }}
                    </span>

                    <h3 class="mt-2 text-lg font-bold text-slate-950 group-hover:text-blue-700">
                        {{ $event->title }}
                    </h3>

                    @if ($event->description)
                        <p class="mt-2 line-clamp-2 text-sm text-slate-600">
                            {{ $event->description }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    🕐 {{ $event->start_at->format('H:i') }}
                    @if ($event->end_at)
                        - {{ $event->end_at->format('H:i') }}
                    @endif
                </span>

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
            </div>
        </div>
    </div>
</a>
