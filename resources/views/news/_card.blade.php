<article class="group overflow-hidden bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

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

        <h2 class="mt-3 text-xl font-bold leading-tight">
            {{ $item->title }}
        </h2>

        @if ($item->excerpt)
            <p class="mt-4 text-sm leading-6 text-slate-600">
                {{ $item->excerpt }}
            </p>
        @endif

        @if ($item->published_at)
            <p class="mt-5 text-xs text-slate-400">
                {{ $item->published_at->format('d/m/Y') }}
            </p>
        @endif

        <a href="{{ url('/noticias/' . $item->slug) }}"
            class="mt-7 inline-block text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
            Leer noticia →
        </a>

    </div>

</article>
