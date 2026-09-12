@extends('layouts.app')

@section('title', 'Noticias | Jorge Pinto')

@section('content')

    {{-- Encabezado --}}
    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-20">

            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                Jorge Pinto
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight md:text-6xl">
                Noticias
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Conoce las últimas actividades, propuestas e iniciativas de Jorge Pinto.
            </p>

        </div>
    </section>


    {{-- Noticias --}}
    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-6">

            <div id="news-grid" class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($news as $item)
                    @include('news._card', ['item' => $item])
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        No hay noticias publicadas.
                    </div>
                @endforelse

            </div>

            @if ($totalNews > $news->count())
                <div class="mt-14 flex justify-center">
                    <button id="load-more-news" type="button" data-offset="{{ $news->count() }}"
                        class="inline-flex items-center gap-3 border border-slate-300 bg-white px-8 py-4 text-sm font-bold uppercase tracking-wide text-slate-900 transition hover:border-blue-700 hover:text-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                        <span class="btn-text">Cargar más noticias</span>
                    </button>
                </div>
            @endif

        </div>
    </section>

    <script>
        (function() {
            const button = document.getElementById('load-more-news');
            if (!button) return;

            const grid = document.getElementById('news-grid');
            const btnText = button.querySelector('.btn-text');

            button.addEventListener('click', function() {
                const offset = parseInt(button.dataset.offset, 10);

                button.disabled = true;
                btnText.textContent = 'Cargando...';

                fetch(`{{ url('/noticias/cargar-mas') }}?offset=${offset}`)
                    .then((response) => response.json())
                    .then((data) => {
                        grid.insertAdjacentHTML('beforeend', data.html);
                        button.dataset.offset = offset + {{ $perPage }};

                        if (!data.hasMore) {
                            button.remove();
                        } else {
                            button.disabled = false;
                            btnText.textContent = 'Cargar más noticias';
                        }
                    })
                    .catch(() => {
                        button.disabled = false;
                        btnText.textContent = 'Cargar más noticias';
                    });
            });
        })();
    </script>

@endsection
