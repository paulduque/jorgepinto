<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $settings = \App\Models\SiteSetting::current();
    @endphp

    @if ($settings?->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @endif

    <title>@yield('title', 'Jorge Pinto')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-white text-slate-900 antialiased">

    @include('components.header')

    <main class="pt-20">
        @yield('content')
    </main>

    {{-- Botón volver arriba --}}
    <button id="back-to-top" type="button" aria-label="Volver arriba"
        class="fixed bottom-20 right-6 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-slate-950 text-white opacity-0 shadow-[0_0_20px_rgba(255,255,255,0.35)] ring-1 ring-white/20 transition-all duration-300 pointer-events-none hover:bg-blue-700 hover:shadow-[0_0_28px_rgba(255,255,255,0.5)] md:bottom-24 md:right-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        (function() {
            const button = document.getElementById('back-to-top');
            if (!button) return;

            function toggleVisibility() {
                if (window.scrollY > 400) {
                    button.classList.remove('opacity-0', 'pointer-events-none');
                    button.classList.add('opacity-100');
                } else {
                    button.classList.add('opacity-0', 'pointer-events-none');
                    button.classList.remove('opacity-100');
                }
            }

            window.addEventListener('scroll', toggleVisibility);
            toggleVisibility();

            button.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        })();
    </script>

    @include('components.footer')

    @stack('scripts')
</body>

</html>
