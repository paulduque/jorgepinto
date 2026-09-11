@extends('layouts.app')

@section('title', 'Jorge Pinto | Sitio Oficial')

@section('content')

    {{-- HERO --}}
    @if ($hero)
        <section class="relative min-h-[calc(100vh-5rem)] overflow-hidden bg-slate-950">

            {{-- Imagen --}}
            @if ($hero->image)
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $hero->image) }}" alt="{{ $hero->title }}"
                        class="hero-image h-full w-full object-cover">
                </div>
            @endif

            {{-- Capas de contraste --}}
            <div class="absolute inset-0 bg-slate-950/10"></div>

            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/20 to-transparent"></div>

            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/10"></div>

            {{-- Contenido --}}
            <div class="relative mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl items-end px-6 pb-16 pt-24 md:pb-24">

                <div class="max-w-4xl text-white">

                    {{-- Nombre --}}
                    <div class="hero-reveal mb-6 flex items-center gap-4" style="--delay: 100ms;">
                        <span class="h-1 w-12 bg-blue-400"></span>

                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-300 md:text-sm">
                            {{ $settings?->person_name ?? 'Jorge Pinto' }}
                        </p>
                    </div>

                    {{-- Título --}}
                    <h1 class="hero-reveal max-w-4xl text-5xl font-black leading-[0.95] tracking-[-0.03em] md:text-7xl lg:text-8xl"
                        style="--delay: 220ms;">
                        {{ $hero->title }}
                    </h1>

                    {{-- Descripción --}}
                    @if ($hero->description)
                        <p class="hero-reveal mt-8 max-w-2xl text-base leading-7 text-slate-200 md:text-xl md:leading-8"
                            style="--delay: 340ms;">
                            {{ $hero->description }}
                        </p>
                    @endif

                    {{-- Botones --}}
                    @if ($hero->primary_button_text || $hero->secondary_button_text)
                        <div class="hero-reveal mt-9 flex flex-wrap gap-4" style="--delay: 460ms;">

                            @if ($hero->primary_button_text)
                                <a href="{{ $hero->primary_button_url ?: '#' }}"
                                    class="group inline-flex items-center gap-3 bg-white px-7 py-4 text-sm font-bold uppercase tracking-wide text-slate-950 transition duration-300 hover:bg-blue-400 hover:text-white">
                                    {{ $hero->primary_button_text }}

                                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                                        →
                                    </span>
                                </a>
                            @endif

                            @if ($hero->secondary_button_text)
                                <a href="{{ $hero->secondary_button_url ?: '#' }}"
                                    class="group inline-flex items-center gap-3 border border-white/60 bg-white/5 px-7 py-4 text-sm font-bold uppercase tracking-wide text-white backdrop-blur-sm transition duration-300 hover:bg-white hover:text-slate-950">
                                    {{ $hero->secondary_button_text }}

                                    <span class="transition-transform duration-300 group-hover:translate-x-1">
                                        →
                                    </span>
                                </a>
                            @endif

                        </div>
                    @endif

                </div>
            </div>

            {{-- Indicador --}}
            <div class="absolute bottom-7 right-6 hidden items-center gap-4 text-white/70 md:flex">

                <span class="text-[10px] font-bold uppercase tracking-[0.25em]">
                    Explora
                </span>

                <span class="flex h-10 w-6 items-start justify-center rounded-full border border-white/40 p-1">
                    <span class="h-2 w-1 rounded-full bg-white animate-bounce"></span>
                </span>

            </div>

        </section>
    @endif


    {{-- LOS MOMENTOS --}}
    <section class="bg-white py-24 md:py-32">
        <div class="mx-auto max-w-7xl px-6">

            {{-- Encabezado --}}
            <div class="grid gap-8 md:grid-cols-12 md:items-end">
                <div class="md:col-span-7">
                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                        Los momentos
                    </p>

                    <h2 class="mt-5 text-4xl font-black leading-tight tracking-[-0.03em] text-slate-950 md:text-6xl">
                        Una mirada al trabajo,
                        <span class="text-slate-400">las ideas y las personas.</span>
                    </h2>
                </div>

                <div class="md:col-span-5 md:pb-2">
                    <p class="max-w-xl text-base leading-7 text-slate-600 md:text-lg">
                        Conoce las actividades, propuestas y momentos que forman parte
                        de este proyecto y de su visión para el futuro.
                    </p>
                </div>
            </div>

            {{-- Bloque editorial --}}
            <div class="mt-16 grid gap-6 md:grid-cols-12">

                {{-- Imagen principal --}}
                <div class="group relative overflow-hidden bg-slate-100 md:col-span-8">
                    <div class="aspect-[16/10] overflow-hidden">
                        @if ($news->first()?->image)
                            <img src="{{ asset('storage/' . $news->first()->image) }}" alt="{{ $news->first()->title }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center bg-slate-200">
                                <span class="text-sm font-bold uppercase tracking-widest text-slate-500">
                                    Imagen principal
                                </span>
                            </div>
                        @endif
                    </div>

                    <div
                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/90 to-transparent p-6 pt-24 md:p-10 md:pt-32">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-300">
                            {{ $news->first()?->category ?? 'Propuestas' }}
                        </p>

                        <h3 class="mt-3 max-w-2xl text-2xl font-black leading-tight text-white md:text-4xl">
                            {{ $news->first()?->title ?? 'Un nuevo camino para nuestro país' }}
                        </h3>
                    </div>
                </div>

                {{-- Texto lateral --}}
                <div class="flex flex-col justify-between bg-slate-950 p-8 text-white md:col-span-4 md:p-10">
                    <div>
                        <span class="text-5xl font-black text-blue-400">01</span>

                        <h3 class="mt-8 text-2xl font-bold leading-tight md:text-3xl">
                            Propuestas que buscan transformar nuestro país.
                        </h3>

                        <p class="mt-6 text-sm leading-7 text-slate-300">
                            Un espacio para conocer las principales ideas, iniciativas
                            y temas que forman parte de esta visión.
                        </p>
                    </div>

                    <a href="/temas"
                        class="group mt-10 inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-white">
                        Explorar temas
                        <span class="transition-transform duration-300 group-hover:translate-x-2">
                            →
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- La historia --}}
    <section class="overflow-hidden bg-slate-100 py-24 md:py-32">
        <div class="mx-auto max-w-7xl px-6">

            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-20">

                {{-- Imagen --}}
                <div class="relative lg:col-span-7">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-200">
                        @if ($profile && $profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center">
                                <span class="text-sm font-bold uppercase tracking-widest text-slate-400">
                                    Fotografía
                                </span>
                            </div>
                        @endif
                    </div>
                    {{-- Número editorial --}}
                    <div class="absolute -bottom-6 -right-2 hidden bg-blue-700 px-7 py-5 text-white md:block">
                        <span class="text-4xl font-black">02</span>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="lg:col-span-5">

                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                        La historia
                    </p>

                    <h2 class="mt-5 text-4xl font-black leading-[1.05] tracking-[-0.03em] text-slate-950 md:text-5xl">
                        Conocer el camino para entender hacia dónde vamos.
                    </h2>

                    <div class="mt-8 h-1 w-14 bg-blue-700"></div>

                    <p class="mt-8 text-base leading-8 text-slate-600">
                        Cada experiencia, cada desafío y cada decisión forma parte
                        de una historia que continúa construyéndose.
                    </p>

                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Este espacio permitirá conocer la trayectoria, las ideas
                        y las experiencias que han marcado el camino de Jorge Pinto.
                    </p>

                    <a href="/perfil"
                        class="group mt-9 inline-flex items-center gap-4 border-b-2 border-slate-950 pb-2 text-sm font-bold uppercase tracking-wider text-slate-950 transition hover:border-blue-700 hover:text-blue-700">
                        Conocer la historia

                        <span class="transition-transform duration-300 group-hover:translate-x-2">
                            →
                        </span>
                    </a>

                </div>
            </div>

        </div>
    </section>


    {{-- TEMAS --}}
    <section class="bg-slate-950 py-24 md:py-32">
        <div class="mx-auto max-w-7xl px-6">

            {{-- Encabezado --}}
            <div class="grid gap-8 md:grid-cols-12 md:items-end">
                <div class="md:col-span-8">
                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-400">
                        Prioridades
                    </p>

                    <h2 class="mt-5 max-w-4xl text-4xl font-black leading-[1.05] tracking-[-0.03em] text-white md:text-6xl">
                        Los temas que
                        <span class="text-slate-500">importan.</span>
                    </h2>
                </div>

                <div class="md:col-span-4 md:text-right">
                    <a href="/temas"
                        class="group inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-white">
                        Ver todos los temas
                        <span class="transition-transform duration-300 group-hover:translate-x-2">
                            →
                        </span>
                    </a>
                </div>
            </div>

            {{-- Lista editorial --}}
            <div class="mt-16 border-t border-white/15">

                @foreach ($themes as $index => $theme)
                    <a href="{{ url('/temas/' . $theme->slug) }}"
                        class="group relative grid gap-6 border-b border-white/15 py-8 transition md:grid-cols-12 md:items-center md:gap-8 md:py-10">

                        {{-- Número --}}
                        <div class="md:col-span-1">
                            <span class="text-sm font-bold tracking-widest text-blue-400">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Título y descripción --}}
                        <div class="md:col-span-6">
                            <h3
                                class="text-2xl font-black tracking-tight text-white transition duration-300 group-hover:text-blue-400 md:text-4xl">
                                {{ $theme->title }}
                            </h3>

                            @if ($theme->description)
                                <p class="mt-3 max-w-xl text-sm leading-6 text-slate-400 md:text-base">
                                    {{ $theme->description }}
                                </p>
                            @endif
                        </div>

                        {{-- Imagen --}}
                        <div class="relative overflow-hidden md:col-span-4">
                            <div class="aspect-[16/7] overflow-hidden bg-slate-800">
                                @if ($theme->image)
                                    <img src="{{ asset('storage/' . $theme->image) }}" alt="{{ $theme->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center">
                                        <span class="text-xs font-bold uppercase tracking-widest text-slate-500">
                                            Imagen
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Flecha --}}
                        <div class="flex justify-start md:col-span-1 md:justify-end">
                            <span
                                class="flex h-12 w-12 items-center justify-center border border-white/20 text-xl text-white transition duration-300 group-hover:border-blue-400 group-hover:bg-blue-400 group-hover:text-slate-950">
                                →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- NOTICIAS --}}
    <section class="bg-white py-24 md:py-32">
        <div class="mx-auto max-w-7xl px-6">

            {{-- Encabezado --}}
            <div class="flex flex-col justify-between gap-6 border-b border-slate-200 pb-8 md:flex-row md:items-end">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                        Sala de prensa
                    </p>

                    <h2 class="mt-4 text-4xl font-black tracking-[-0.03em] text-slate-950 md:text-6xl">
                        Noticias y actividades
                    </h2>
                </div>

                <a href="/noticias"
                    class="group inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-slate-950 transition hover:text-blue-700">
                    Ver todas las noticias
                    <span class="transition-transform duration-300 group-hover:translate-x-2">
                        →
                    </span>
                </a>
            </div>

            @if ($news->isNotEmpty())

                {{-- Noticia principal --}}
                @php
                    $featuredNews = $news->first();
                    $secondaryNews = $news->skip(1);
                @endphp

                <div class="mt-12 grid gap-8 lg:grid-cols-12">

                    {{-- Principal --}}
                    <article class="group lg:col-span-8">
                        <a href="{{ url('/noticias/' . $featuredNews->slug) }}">

                            @if ($featuredNews->image)
                                <div class="aspect-[16/9] overflow-hidden bg-slate-100">
                                    <img src="{{ asset('storage/' . $featuredNews->image) }}"
                                        alt="{{ $featuredNews->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                </div>
                            @endif

                            <div class="mt-7 max-w-3xl">
                                <div
                                    class="flex flex-wrap items-center gap-4 text-xs font-bold uppercase tracking-[0.2em]">
                                    @if ($featuredNews->category)
                                        <span class="text-blue-700">
                                            {{ $featuredNews->category }}
                                        </span>
                                    @endif

                                    @if ($featuredNews->published_at)
                                        <span class="text-slate-400">
                                            {{ $featuredNews->published_at->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>

                                <h3
                                    class="mt-4 text-3xl font-black leading-tight tracking-[-0.02em] text-slate-950 transition group-hover:text-blue-700 md:text-5xl">
                                    {{ $featuredNews->title }}
                                </h3>

                                @if ($featuredNews->excerpt)
                                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 md:text-lg">
                                        {{ $featuredNews->excerpt }}
                                    </p>
                                @endif

                                <span
                                    class="mt-6 inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-slate-950">
                                    Leer noticia
                                    <span class="transition-transform duration-300 group-hover:translate-x-2">
                                        →
                                    </span>
                                </span>
                            </div>
                        </a>
                    </article>

                    {{-- Noticias secundarias --}}
                    @if ($secondaryNews->isNotEmpty())
                        <div class="divide-y divide-slate-200 lg:col-span-4">
                            @foreach ($secondaryNews as $item)
                                <article class="group py-0 first:pt-0 lg:py-8">
                                    <a href="{{ url('/noticias/' . $item->slug) }}">

                                        @if ($item->image)
                                            <div class="aspect-[16/9] overflow-hidden bg-slate-100">
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->title }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                            </div>
                                        @endif

                                        <div class="py-6 lg:pb-0">
                                            <div
                                                class="flex flex-wrap items-center gap-3 text-[10px] font-bold uppercase tracking-[0.2em]">
                                                @if ($item->category)
                                                    <span class="text-blue-700">
                                                        {{ $item->category }}
                                                    </span>
                                                @endif

                                                @if ($item->published_at)
                                                    <span class="text-slate-400">
                                                        {{ $item->published_at->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h3
                                                class="mt-3 text-xl font-black leading-tight text-slate-950 transition group-hover:text-blue-700">
                                                {{ $item->title }}
                                            </h3>

                                            <span class="mt-4 inline-flex text-sm font-bold text-slate-950">
                                                Leer más →
                                            </span>
                                        </div>

                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @endif

                </div>
            @else
                <div class="mt-12 border border-slate-200 px-6 py-16 text-center">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-400">
                        No hay noticias publicadas.
                    </p>
                </div>

            @endif

        </div>
    </section>

@endsection
