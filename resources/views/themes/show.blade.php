@extends('layouts.app')

@section('title', $theme->title . ' | Jorge Pinto')

@section('content')

    {{-- Encabezado --}}
    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-5xl px-6 py-20">

            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                Temas
            </p>

            <h1 class="mt-5 text-4xl font-black leading-tight md:text-6xl">
                {{ $theme->title }}
            </h1>

        </div>
    </section>

    {{-- Imagen principal --}}
    @if ($theme->image)
        <section class="bg-white">
            <div class="mx-auto max-w-6xl px-6 py-10">
                <div class="aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $theme->image) }}" alt="{{ $theme->title }}"
                        class="h-full w-full object-cover">
                </div>
            </div>
        </section>
    @endif

    {{-- Contenido --}}
    <section class="bg-white">
        <div class="mx-auto max-w-3xl px-6 pb-20">

            @if ($theme->description)
                <div class="text-lg leading-8 text-slate-700">
                    {{ $theme->description }}
                </div>
            @endif

            <div class="mt-14 border-t border-slate-200 pt-8">
                <a href="/" class="text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                    ← Volver al inicio
                </a>
            </div>

        </div>
    </section>

@endsection
