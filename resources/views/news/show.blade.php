@extends('layouts.app')

@section('title', $news->title . ' | Jorge Pinto')

@section('content')

    {{-- Encabezado --}}
    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-5xl px-6 py-20">

            @if ($news->category)
                <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                    {{ $news->category }}
                </p>
            @endif

            <h1 class="mt-5 text-4xl font-black leading-tight md:text-6xl">
                {{ $news->title }}
            </h1>

            @if ($news->published_at)
                <p class="mt-6 text-sm text-slate-400">
                    {{ $news->published_at->translatedFormat('d \d\e F \d\e Y') }}
                </p>
            @endif

        </div>
    </section>

    {{-- Imagen --}}
    @if ($news->image)
        <section class="bg-white">
            <div class="mx-auto max-w-6xl px-6 py-10">
                <div class="aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                        class="h-full w-full object-cover">
                </div>
            </div>
        </section>
    @endif

    {{-- Contenido --}}
    <article class="bg-white">
        <div class="mx-auto max-w-3xl px-6 pb-20">

            @if ($news->excerpt)
                <p class="text-xl font-medium leading-8 text-slate-700">
                    {{ $news->excerpt }}
                </p>
            @endif

            @if ($news->content)
                <div class="prose prose-lg mt-10 max-w-none">
                    {!! $news->content !!}
                </div>
            @endif

            <div class="mt-14 border-t border-slate-200 pt-8">
                <a href="/" class="text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                    ← Volver al inicio
                </a>
            </div>

        </div>
    </article>

@endsection
