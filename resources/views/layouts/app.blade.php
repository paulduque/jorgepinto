<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $settings = \App\Models\SiteSetting::current();
        $personName = $settings?->person_name ?? 'Jorge Pinto';
        $siteName = $settings?->site_name ?? 'Sitio Oficial';
        $siteDescription = $settings?->site_description ?? 'Sitio oficial de Jorge Pinto';
        $pageUrl = url()->current();
    @endphp

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- TITLE --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <title>@yield('title', $personName . ' — ' . $siteName)</title>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- META BÁSICOS --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <meta name="description" content="@yield('meta_description', $siteDescription)">
    <meta name="keywords" content="@yield('meta_keywords', 'Jorge Pinto, campaña, Pichincha, Ecuador, elecciones')">
    <meta name="author" content="{{ $personName }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', $pageUrl)">

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- FAVICON --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @if ($settings?->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- OPEN GRAPH (Facebook, WhatsApp, LinkedIn) --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', $personName . ' — ' . $siteName)">
    <meta property="og:description" content="@yield('og_description', $siteDescription)">
    <meta property="og:url" content="@yield('og_url', $pageUrl)">
    <meta property="og:site_name" content="{{ $personName }} — {{ $siteName }}">
    <meta property="og:image" content="@yield('og_image', asset('favicon.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_title', $personName)">
    <meta property="og:locale" content="es_EC">

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- TWITTER CARDS --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $personName . ' — ' . $siteName)">
    <meta name="twitter:description" content="@yield('og_description', $siteDescription)">
    <meta name="twitter:image" content="@yield('og_image', asset('favicon.png'))">
    @if ($settings?->twitter)
        @php
            $twitterHandle = '@' . ltrim(parse_url($settings->twitter, PHP_URL_PATH) ?? '', '/');
        @endphp
        <meta name="twitter:site" content="{{ $twitterHandle }}">
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- TEMA / PWA --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#1a3a6b">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#0f2547">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- JSON-LD SCHEMA (Google Rich Snippets) --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    @include('partials.seo-schema')
</head>

<body class="overflow-x-hidden bg-white text-slate-900 antialiased">

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
