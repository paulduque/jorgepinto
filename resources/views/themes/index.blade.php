@extends('layouts.app')

@section('title', 'Temas | Jorge Pinto')

@section('content')

    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-20">
            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                Jorge Pinto
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight md:text-6xl">
                Temas
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Conoce las principales propuestas e iniciativas para construir un mejor futuro.
            </p>
        </div>
    </section>

    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-6">

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

                @forelse ($themes as $theme)
                    <article
                        class="group overflow-hidden bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                        @if ($theme->image)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $theme->image) }}" alt="{{ $theme->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            </div>
                        @endif

                        <div class="p-7">

                            <div class="mb-6 h-1 w-12 bg-blue-700"></div>

                            <h2 class="text-xl font-bold">
                                {{ $theme->title }}
                            </h2>

                            @if ($theme->description)
                                <p class="mt-4 text-sm leading-6 text-slate-600">
                                    {{ $theme->description }}
                                </p>
                            @endif

                            <a href="{{ url('/temas/' . $theme->slug) }}"
                                class="mt-7 inline-block text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                                Conocer más →
                            </a>

                        </div>

                    </article>

                @empty

                    <p class="col-span-full py-12 text-center text-slate-500">
                        No hay temas publicados.
                    </p>
                @endforelse

            </div>

        </div>
    </section>

@endsection
