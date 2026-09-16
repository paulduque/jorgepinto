@extends('layouts.app')

@section('title', 'Jorge Pinto | Sitio Oficial')

@section('content')

    {{-- HERO --}}
    @if ($heroes->isNotEmpty())
        <section class="relative min-h-[calc(100vh-5rem)] overflow-hidden bg-slate-950">

            <div id="hero-carousel" class="relative min-h-[calc(100vh-5rem)]">

                @foreach ($heroes as $index => $hero)
                    <div class="hero-slide absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'z-10 opacity-100' : 'pointer-events-none z-0 opacity-0' }}"
                        data-index="{{ $index }}">

                        {{-- Imagen --}}
                        @if ($hero->image)
                            <div class="absolute inset-0">
                                <img src="{{ asset('storage/' . $hero->image) }}" alt="{{ $hero->title }}"
                                    class="hero-image h-full w-full object-cover">
                            </div>
                        @endif

                        {{-- Capas de contraste --}}
                        <div class="absolute inset-0 bg-slate-950/10"></div>

                        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/20 to-transparent">
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/10">
                        </div>

                        {{-- Contenido --}}
                        <div
                            class="relative mx-auto flex min-h-[calc(100vh-5rem)] max-w-7xl items-end px-6 pb-16 pt-24 md:pb-24">

                            <div class="max-w-4xl text-white">

                                {{-- Nombre --}}
                                <div class="hero-reveal mb-6 flex items-center gap-4" style="--delay: 100ms;">
                                    <span class="h-1 w-12 bg-blue-400"></span>

                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-300 md:text-sm">
                                        {{ $settings?->person_name ?? 'Jorge Pinto' }}
                                    </p>
                                </div>

                                {{-- Título --}}
                                <div class="hero-reveal flex items-stretch gap-3 md:gap-5" style="--delay: 220ms;">
                                    @if ($hero->number)
                                        <span id="hero-number-{{ $hero->id }}"
                                            class="select-none shrink-0 overflow-hidden font-black"
                                            style="color: {{ $hero->number_color ?? '#60a5fa' }}; display: flex; align-items: center; justify-content: center;">
                                            {{ $hero->number }}
                                        </span>
                                    @endif

                                    <h1 id="hero-title-{{ $hero->id }}"
                                        class="max-w-4xl text-4xl font-black leading-[0.95] tracking-[-0.03em] md:text-7xl lg:text-8xl">
                                        {{ $hero->title }}
                                    </h1>
                                </div>

                                @if ($hero->number)
                                    <script>
                                        (function() {
                                            function matchHeroNumberHeight() {
                                                const number = document.getElementById('hero-number-{{ $hero->id }}');
                                                const title = document.getElementById('hero-title-{{ $hero->id }}');
                                                if (!number || !title) return;

                                                const height = title.offsetHeight;

                                                number.style.height = height + 'px';
                                                number.style.lineHeight = '1';
                                                number.style.fontSize = (height * 1.1) + 'px';
                                                number.style.transform = 'translateY(-5%)';
                                            }

                                            window.addEventListener('load', matchHeroNumberHeight);
                                            window.addEventListener('resize', matchHeroNumberHeight);
                                        })
                                        ();
                                    </script>
                                @endif

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

                    </div>
                @endforeach

                {{-- Puntos de navegación --}}
                @if ($heroes->count() > 1)
                    <div class="absolute bottom-7 left-1/2 z-20 flex -translate-x-1/2 gap-2">
                        @foreach ($heroes as $index => $hero)
                            <button type="button"
                                class="hero-dot h-2 w-2 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/40' }}"
                                data-index="{{ $index }}" aria-label="Ir a la portada {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Indicador --}}
                <div class="absolute bottom-7 right-6 z-20 hidden items-center gap-4 text-white/70 md:flex">

                    <span class="text-[10px] font-bold uppercase tracking-[0.25em]">
                        Explora
                    </span>

                    <span class="flex h-10 w-6 items-start justify-center rounded-full border border-white/40 p-1">
                        <span class="h-2 w-1 rounded-full bg-white animate-bounce"></span>
                    </span>

                </div>

            </div>

        </section>

        @if ($heroes->count() > 1)
            <script>
                (function() {
                    const slides = document.querySelectorAll('#hero-carousel .hero-slide');
                    const dots = document.querySelectorAll('#hero-carousel .hero-dot');
                    let current = 0;
                    let timer;

                    function goTo(index) {
                        slides[current].classList.add('opacity-0', 'z-0', 'pointer-events-none');
                        slides[current].classList.remove('opacity-100', 'z-10');

                        if (dots[current]) {
                            dots[current].classList.remove('bg-white');
                            dots[current].classList.add('bg-white/40');
                        }

                        current = index;

                        slides[current].classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                        slides[current].classList.add('opacity-100', 'z-10');

                        if (dots[current]) {
                            dots[current].classList.add('bg-white');
                            dots[current].classList.remove('bg-white/40');
                        }
                    }

                    function next() {
                        goTo((current + 1) % slides.length);
                    }

                    function startAutoplay() {
                        timer = setInterval(next, 6000);
                    }

                    function stopAutoplay() {
                        clearInterval(timer);
                    }

                    dots.forEach(function(dot) {
                        dot.addEventListener('click', function() {
                            stopAutoplay();
                            goTo(parseInt(dot.dataset.index, 10));
                            startAutoplay();
                        });
                    });

                    startAutoplay();
                })();
            </script>
        @endif
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
            @if ($news->isNotEmpty())
                <div class="mt-16 grid gap-6 md:grid-cols-12">

                    @php
                        $featuredMoment = $news->first();
                        $secondaryMoment = $news->skip(1)->first();
                    @endphp

                    {{-- Noticia principal --}}
                    <article class="group relative overflow-hidden bg-slate-100 md:col-span-8">
                        <a href="{{ url('/noticias/' . $featuredMoment->slug) }}" class="block h-full">
                            <div class="aspect-[16/10] overflow-hidden">
                                @if ($featuredMoment->image)
                                    <img src="{{ asset('storage/' . $featuredMoment->image) }}"
                                        alt="{{ $featuredMoment->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-slate-200">
                                        <span class="text-sm font-bold uppercase tracking-widest text-slate-500">
                                            Sin imagen
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div
                                class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/90 to-transparent p-6 pt-24 md:p-10 md:pt-32">
                                @if ($featuredMoment->category)
                                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-300">
                                        {{ $featuredMoment->category }}
                                    </p>
                                @endif

                                <h3 class="mt-3 max-w-2xl text-2xl font-black leading-tight text-white md:text-4xl">
                                    {{ $featuredMoment->title }}
                                </h3>
                            </div>
                        </a>
                    </article>

                    {{-- Noticia secundaria (lateral) --}}
                    @if ($secondaryMoment)
                        <article class="flex flex-col justify-between bg-slate-950 p-8 text-white md:col-span-4 md:p-10">
                            <div>
                                {{-- Leyenda Lista 3 --}}
                                @if ($settings?->list_number)
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-400">
                                        {{ $settings->list_number }}
                                    </p>
                                    <div class="mt-4 h-px w-12 bg-blue-400"></div>
                                @endif

                                <h3 class="mt-6 text-2xl font-bold leading-tight md:text-3xl">
                                    {{ $secondaryMoment->title }}
                                </h3>

                                @if ($secondaryMoment->excerpt)
                                    <p class="mt-6 text-sm leading-7 text-slate-300">
                                        {{ Str::limit($secondaryMoment->excerpt, 150) }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ url('/noticias/' . $secondaryMoment->slug) }}"
                                class="group mt-10 inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-white">
                                Leer noticia
                                <span class="transition-transform duration-300 group-hover:translate-x-2">
                                    →
                                </span>
                            </a>
                        </article>
                    @else
                        {{-- Fallback: si solo hay 1 noticia --}}
                        <div class="flex flex-col justify-between bg-slate-950 p-8 text-white md:col-span-4 md:p-10">
                            <div>
                                @if ($settings?->list_number)
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-400">
                                        {{ $settings->list_number }}
                                    </p>
                                    <div class="mt-4 h-px w-12 bg-blue-400"></div>
                                @endif

                                <h3 class="mt-6 text-2xl font-bold leading-tight md:text-3xl">
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
                    @endif

                </div>

                {{-- Enlace ver todas las noticias --}}
                <div class="mt-12 text-center">
                    <a href="/noticias"
                        class="group inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wider text-blue-700 transition hover:text-blue-900">
                        Ver todas las noticias
                        <span class="transition-transform duration-300 group-hover:translate-x-2">
                            →
                        </span>
                    </a>
                </div>
            @else
                {{-- Sin noticias --}}
                <div class="mt-16 border border-slate-200 px-6 py-16 text-center">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-400">
                        No hay noticias publicadas.
                    </p>
                </div>
            @endif

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
                    {{-- 👈 LEYENDA LISTA 3 (dinámica) --}}
                    @if ($settings?->list_number)
                        <div class="absolute -bottom-6 -right-2 hidden bg-blue-700 px-7 py-5 text-white md:block">
                            <span class="text-2xl font-black uppercase tracking-wider">
                                {{ $settings->list_number }}
                            </span>
                        </div>
                    @endif
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
                    <div class="flex items-center gap-4">
                        <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-400">
                            Prioridades
                        </p>

                        @if ($settings?->list_number)
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                · {{ $settings->list_number }}
                            </span>
                        @endif
                    </div>

                    <h2
                        class="mt-5 max-w-4xl text-4xl font-black leading-[1.05] tracking-[-0.03em] text-white md:text-6xl">
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

                {{-- Siguiente Noticia principal --}}
                @php
                    // Sala de prensa empieza desde la 2ª noticia (la 1ª ya está en Los momentos)
                    $featuredNews = $news->skip(1)->first() ?? $news->first();
                    $secondaryNews = $news->skip(2)->take(2); // Tomar las siguientes 2 noticias
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
