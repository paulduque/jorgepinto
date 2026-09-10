<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Jorge Pinto')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-white text-slate-900 antialiased">

    @include('components.header')

    <main class="pt-20">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>

</html>
