@extends('layouts.app')

@section('title', $theme->title . ' | Jorge Pinto')

@section('content')

    {{-- Hero del tema --}}
    <section class="relative min-h-[50vh] w-full overflow-hidden bg-slate-950 md:min-h-[70vh]">

        {{-- Imagen de fondo --}}
        @if ($theme->image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $theme->image) }}" alt="{{ $theme->title }}"
                    class="h-full w-full object-cover object-center">
            </div>
        @endif

        {{-- Capas de contraste --}}
        <div class="absolute inset-0 bg-slate-950/30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-950/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-transparent"></div>

        {{-- Contenido --}}
        <div
            class="relative mx-auto flex min-h-[50vh] w-full max-w-7xl items-end px-6 pb-12 pt-32 md:min-h-[70vh] md:pb-16 md:pt-24">
            <div class="w-full max-w-4xl text-white">

                {{-- Categoría / Lista --}}
                <div class="flex flex-wrap items-center gap-3 md:gap-4">
                    <span class="h-1 w-8 bg-blue-400 md:w-12"></span>
                    <p
                        class="text-[10px] font-bold uppercase tracking-[0.2em] text-blue-300 md:text-sm md:tracking-[0.3em]">
                        @if ($settings?->list_number)
                            {{ $settings->list_number }} ·
                        @endif
                        Prioridades
                    </p>
                </div>

                <h1
                    class="mt-4 text-4xl font-black leading-[0.95] tracking-[-0.03em] sm:text-5xl md:mt-6 md:text-7xl lg:text-8xl">
                    {{ $theme->title }}
                </h1>

                @if ($theme->description)
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-200 sm:text-lg md:mt-8 md:text-xl md:leading-8">
                        {{ $theme->description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    {{-- Contenido principal --}}
    <section class="w-full bg-white py-16 md:py-28">
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">

                {{-- Descripción completa (izquierda) --}}
                <div class="min-w-0 lg:col-span-8">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                            Sobre este tema
                        </span>
                        <span class="h-px flex-1 bg-slate-200"></span>
                    </div>

                    @if ($theme->full_description)
                        {{-- Tarjeta contenedora --}}
                        <div
                            class="mt-6 rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-sm sm:p-8 md:mt-8 md:p-12">

                            {{-- Encabezado decorativo --}}
                            <div class="mb-6 flex items-center gap-4 md:mb-8">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-700 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-700">
                                        En detalle
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Conoce nuestra propuesta
                                    </p>
                                </div>
                            </div>

                            {{-- Contenido enriquecido --}}
                            <div
                                class="prose prose-base prose-slate max-w-none
                            prose-headings:font-black prose-headings:tracking-tight prose-headings:text-slate-950
                            prose-h2:mt-8 prose-h2:text-2xl md:prose-h2:text-3xl
                            prose-h3:mt-6 prose-h3:text-xl md:prose-h3:text-2xl
                            prose-p:leading-7 prose-p:text-slate-700 md:prose-p:leading-9 md:prose-p:text-lg
                            prose-p:my-4 md:prose-p:my-6
                            prose-a:text-blue-700 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
                            prose-strong:font-bold prose-strong:text-slate-950
                            prose-ul:my-4 md:prose-ul:my-6 prose-li:my-2 md:prose-li:my-3
                            prose-blockquote:border-l-4 prose-blockquote:border-blue-700 prose-blockquote:bg-blue-50 prose-blockquote:py-2 prose-blockquote:pl-4 md:prose-blockquote:pl-6 prose-blockquote:not-italic prose-blockquote:text-slate-700">
                                {!! $theme->full_description !!}
                            </div>
                        </div>
                    @else
                        <div
                            class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center md:mt-8 md:p-12">
                            <div class="text-4xl">📝</div>
                            <p class="mt-4 text-lg font-semibold text-slate-600">
                                Información detallada próximamente
                            </p>
                            <p class="mt-2 text-sm text-slate-500">
                                Estamos preparando más contenido sobre este tema.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Sidebar (derecha) --}}
                <aside class="min-w-0 lg:col-span-4">
                    <div class="space-y-6 lg:sticky lg:top-24">

                        {{-- Tarjeta de imagen --}}
                        @if ($theme->image)
                            <div class="overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/' . $theme->image) }}" alt="{{ $theme->title }}"
                                    class="aspect-[16/9] w-full object-cover">
                            </div>
                        @endif

                        {{-- Tarjeta de info --}}
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-700">
                                Tema
                            </p>
                            <h3 class="mt-3 text-2xl font-black text-slate-950">
                                {{ $theme->title }}
                            </h3>

                            @if ($theme->description)
                                <p class="mt-4 text-sm leading-6 text-slate-600">
                                    {{ $theme->description }}
                                </p>
                            @endif
                        </div>

                        {{-- Otros temas --}}
                        @php
                            $otherThemes = \App\Models\Theme::where('is_active', true)
                                ->where('id', '!=', $theme->id)
                                ->orderBy('sort_order')
                                ->limit(4)
                                ->get();
                        @endphp

                        @if ($otherThemes->isNotEmpty())
                            <div class="rounded-xl border border-slate-200 bg-white p-6">
                                <p class="text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                                    Otros temas
                                </p>
                                <div class="mt-4 space-y-3">
                                    @foreach ($otherThemes as $other)
                                        <a href="{{ url('/temas/' . $other->slug) }}"
                                            class="group flex items-center gap-3 rounded-lg p-2 transition hover:bg-slate-50">
                                            @if ($other->image)
                                                <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg">
                                                    <img src="{{ asset('storage/' . $other->image) }}"
                                                        alt="{{ $other->title }}" class="h-full w-full object-cover">
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <p
                                                    class="truncate text-sm font-bold text-slate-950 group-hover:text-blue-700">
                                                    {{ $other->title }}
                                                </p>
                                                @if ($other->description)
                                                    <p class="truncate text-xs text-slate-500">
                                                        {{ Str::limit($other->description, 50) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Botón volver --}}
                        <a href="/temas"
                            class="group flex items-center justify-center gap-3 rounded-lg border border-slate-300 bg-white px-6 py-4 text-sm font-bold uppercase tracking-wider text-slate-700 transition hover:bg-slate-950 hover:text-white">
                            <span class="transition-transform duration-300 group-hover:-translate-x-1">←</span>
                            Ver todos los temas
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
