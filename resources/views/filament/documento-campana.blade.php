@php
    $markdown = $contenido ?? '';

    // Convertir markdown a HTML
    $html = \Illuminate\Support\Str::markdown($markdown);

    // Estilos mejorados con más espaciado
    $html = str_replace(
        '<h1>',
        '<h1 class="text-3xl font-black tracking-tight text-slate-950 md:text-4xl mt-16 mb-8 pb-5 border-b-2 border-blue-700">',
        $html,
    );
    $html = str_replace(
        '<h2>',
        '<h2 class="text-2xl font-black tracking-tight text-slate-950 md:text-3xl mt-14 mb-6 pt-4">',
        $html,
    );
    $html = str_replace('<h3>', '<h3 class="text-xl font-bold text-slate-950 mt-10 mb-4">', $html);
    $html = str_replace('<p>', '<p class="text-base leading-8 text-slate-700 my-5">', $html);
    $html = str_replace('<ul>', '<ul class="my-6 space-y-3 pl-6 list-disc marker:text-blue-700">', $html);
    $html = str_replace(
        '<ol>',
        '<ol class="my-6 space-y-3 pl-6 list-decimal marker:text-blue-700 marker:font-bold">',
        $html,
    );
    $html = str_replace('<li>', '<li class="text-base leading-7 text-slate-700 pl-1">', $html);
    $html = str_replace(
        '<blockquote>',
        '<blockquote class="my-8 border-l-4 border-blue-700 bg-blue-50 p-6 text-base leading-8 text-slate-800 rounded-r-lg">',
        $html,
    );
    $html = str_replace('<strong>', '<strong class="font-bold text-slate-950">', $html);
    $html = str_replace('<a ', '<a class="font-semibold text-blue-700 hover:underline" ', $html);
    $html = str_replace(
        '<table>',
        '<table class="my-8 w-full border-collapse border border-slate-200 text-sm rounded-lg overflow-hidden">',
        $html,
    );
    $html = str_replace('<thead>', '<thead class="bg-slate-100">', $html);
    $html = str_replace(
        '<th>',
        '<th class="border border-slate-200 px-4 py-3 text-left font-bold text-slate-950 text-xs uppercase tracking-wider">',
        $html,
    );
    $html = str_replace('<td>', '<td class="border border-slate-200 px-4 py-3 text-slate-700">', $html);
    $html = str_replace('<hr>', '<hr class="my-16 border-t-2 border-slate-200">', $html);
    $html = str_replace('<hr />', '<hr class="my-16 border-t-2 border-slate-200">', $html);
    $html = str_replace(
        '<code>',
        '<code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-sm text-slate-800">',
        $html,
    );
@endphp

<div class="min-h-screen bg-white">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-slate-950 pt-24 pb-16 md:pt-28 md:pb-20">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
        <div class="absolute -right-40 -top-40 h-96 w-96 rounded-full bg-blue-600/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-blue-400/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl px-6">
            <div class="flex items-center gap-4">
                <span class="h-1 w-12 bg-blue-400"></span>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-300 md:text-sm">
                    Campaña 2026
                </p>
            </div>

            <h1 class="mt-6 text-4xl font-black leading-[1.05] tracking-[-0.03em] text-white md:text-5xl">
                {{ $titulo }}
            </h1>

            <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Actualizado: {{ $updated_at }}
                    </span>

                    <span class="hidden h-4 w-px bg-slate-700 md:block"></span>

                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Versión {{ $version }}
                    </span>
                </div>

                {{-- Botón Editar --}}
                <a href="{{ url('/admin/documento-maestro/' . $record_id . '/edit') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg transition hover:bg-blue-700 hover:shadow-xl">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar documento
                </a>
            </div>
        </div>
    </section>

    {{-- Contenido principal --}}
    <article class="bg-white py-16 md:py-20">
        <div class="mx-auto max-w-4xl px-6">
            <div class="documento-contenido">
                {!! $html !!}
            </div>

            {{-- Botón volver --}}
            <div class="mt-20 border-t-2 border-slate-200 pt-10">
                <a href="{{ url('/admin/documento-maestro') }}"
                    class="group inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wide text-slate-950 transition hover:text-blue-700">
                    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al listado
                </a>
            </div>
        </div>
    </article>
</div>
