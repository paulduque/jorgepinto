@extends('layouts.app')

@section('title', 'Buscar | Jorge Pinto')

@section('content')

    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-20">

            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                Jorge Pinto
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight md:text-6xl">
                Buscar
            </h1>

            <form action="/buscar" method="GET" class="mt-10 max-w-3xl">
                <div class="flex flex-col gap-3 sm:flex-row">

                    <input type="search" name="q" value="{{ $query }}" placeholder="¿Qué estás buscando?"
                        class="min-h-14 flex-1 border-0 bg-white px-5 text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-400"
                        autofocus>

                    <button type="submit"
                        class="min-h-14 bg-blue-600 px-8 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-blue-500">
                        Buscar
                    </button>

                </div>
            </form>

        </div>
    </section>


    @if ($query !== '')

        <section class="bg-slate-50 py-20">

            <div class="mx-auto max-w-7xl px-6">

                <p class="text-sm font-bold uppercase tracking-[0.25em] text-blue-700">
                    Resultados
                </p>

                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                    Resultados para “{{ $query }}”
                </h2>


                {{-- Noticias --}}
                @if ($news->count())

                    <div class="mt-12">

                        <h3 class="text-xl font-bold text-slate-900">
                            Noticias
                        </h3>

                        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                            @foreach ($news as $item)
                                <article
                                    class="group overflow-hidden bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                                    @if ($item->image)
                                        <div class="aspect-video overflow-hidden">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        </div>
                                    @endif

                                    <div class="p-7">

                                        @if ($item->category)
                                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                                                {{ $item->category }}
                                            </p>
                                        @endif

                                        <h4 class="mt-3 text-xl font-bold leading-tight">
                                            {{ $item->title }}
                                        </h4>

                                        @if ($item->excerpt)
                                            <p class="mt-4 text-sm leading-6 text-slate-600">
                                                {{ $item->excerpt }}
                                            </p>
                                        @endif

                                        <a href="{{ url('/noticias/' . $item->slug) }}"
                                            class="mt-6 inline-block text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                                            Leer noticia →
                                        </a>

                                    </div>

                                </article>
                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- Temas --}}
                @if ($themes->count())

                    <div class="mt-16">

                        <h3 class="text-xl font-bold text-slate-900">
                            Temas
                        </h3>

                        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-4">

                            @foreach ($themes as $theme)
                                <article
                                    class="bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                                    <div class="mb-6 h-1 w-12 bg-blue-700"></div>

                                    <h4 class="text-xl font-bold">
                                        {{ $theme->title }}
                                    </h4>

                                    @if ($theme->description)
                                        <p class="mt-4 text-sm leading-6 text-slate-600">
                                            {{ $theme->description }}
                                        </p>
                                    @endif

                                    <a href="{{ url('/temas/' . $theme->slug) }}"
                                        class="mt-6 inline-block text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                                        Conocer más →
                                    </a>

                                </article>
                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- Sin resultados --}}
                @if (!$news->count() && !$themes->count())
                    <div class="mt-12 border-l-4 border-blue-700 bg-white p-8">
                        <p class="font-semibold text-slate-900">
                            No encontramos resultados para tu búsqueda.
                        </p>

                        <p class="mt-2 text-sm text-slate-600">
                            Intenta con otra palabra o término.
                        </p>
                    </div>
                @endif

            </div>

        </section>

    @endif

@endsection
