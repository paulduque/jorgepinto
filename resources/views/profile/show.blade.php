@extends('layouts.app')

@section('title', $profile->name . ' | Jorge Pinto')

@section('content')

    {{-- Presentación --}}
    <section class="bg-slate-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-6 py-16 md:grid-cols-2 md:items-center md:py-24">

            <div>
                <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                    Jorge Pinto
                </p>

                <h1 class="mt-5 text-5xl font-black leading-[1.05] tracking-tight md:text-7xl">
                    {{ $profile->name }}
                </h1>

                @if ($profile->position)
                    <p class="mt-6 text-xl font-medium text-slate-300">
                        {{ $profile->position }}
                    </p>
                @endif

                @if ($profile->intro)
                    <p class="mt-8 max-w-xl text-lg leading-8 text-slate-300">
                        {{ $profile->intro }}
                    </p>
                @endif
            </div>

            @if ($profile->photo)
                <div class="overflow-hidden bg-slate-800">
                    <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}"
                        class="aspect-[4/5] h-full w-full object-cover">
                </div>
            @endif

        </div>
    </section>


    {{-- Frase destacada --}}
    @if ($profile->quote)
        <section class="border-b border-slate-200 bg-white">
            <div class="mx-auto max-w-5xl px-6 py-20 text-center">

                <div class="mx-auto mb-8 h-1 w-16 bg-blue-700"></div>

                <blockquote class="text-3xl font-bold leading-tight tracking-tight text-slate-900 md:text-5xl">
                    “{{ $profile->quote }}”
                </blockquote>

            </div>
        </section>
    @endif


    {{-- Biografía --}}
    @if ($profile->biography)
        <section class="bg-slate-50">
            <div class="mx-auto max-w-4xl px-6 py-20 md:py-28">

                <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                    Trayectoria
                </p>

                <h2 class="mt-4 text-3xl font-black tracking-tight text-slate-950 md:text-4xl">
                    Sobre Jorge Pinto
                </h2>

                <div class="mt-10 text-lg leading-8 text-slate-700">
                    {!! $profile->biography !!}
                </div>

            </div>
        </section>
    @endif


    {{-- Foto secundaria --}}
    @if ($profile->secondary_photo)
        <section class="bg-white">
            <div class="mx-auto max-w-6xl px-6 py-16 md:py-20">

                <div class="aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $profile->secondary_photo) }}" alt="{{ $profile->name }}"
                        class="h-full w-full object-cover">
                </div>

            </div>
        </section>
    @endif


    {{-- Navegación --}}
    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-10">

            <a href="/"
                class="inline-flex items-center text-sm font-bold uppercase tracking-wide text-blue-700 transition hover:text-blue-900">
                ← Volver al inicio
            </a>

        </div>
    </section>

@endsection
