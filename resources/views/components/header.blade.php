@php
    $settings = \App\Models\SiteSetting::current();
    $showAgenda = $settings?->agenda_link_visible ?? true;
    $agendaOnlyAuth = $settings?->agenda_link_public_only ?? false;
    $canSeeAgenda = $showAgenda && (!$agendaOnlyAuth || \Illuminate\Support\Facades\Auth::check());
@endphp

<header x-data="{ open: false, searchOpen: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-white/95 shadow-lg backdrop-blur-md' : 'bg-white'">

    {{-- Barra principal --}}
    <div class="border-b border-slate-200">

        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">

            {{-- Logo --}}
            <a href="/" class="group flex items-center gap-3">

                @if ($settings?->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}"
                        alt="{{ $settings->person_name ?? 'Jorge Pinto' }}"
                        class="h-12 w-12 object-contain transition duration-300 group-hover:scale-105">
                @else
                    <div class="flex h-12 w-12 items-center justify-center bg-slate-950 text-lg font-black text-white">
                        JP
                    </div>
                @endif

                <div>
                    <div class="text-lg font-black tracking-tight text-slate-950">
                        {{ $settings?->person_name ?? 'JORGE PINTO' }}
                    </div>

                    <div class="text-[10px] font-semibold uppercase tracking-[0.22em] text-slate-500">
                        {{ $settings?->site_name ?? 'Sitio oficial' }}
                    </div>
                </div>

            </a>


            {{-- Navegación desktop --}}
            <nav class="hidden items-center gap-7 lg:flex">

                <a href="/"
                    class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                    Inicio
                    <span
                        class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>

                <a href="/perfil"
                    class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                    Jorge Pinto
                    <span
                        class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>

                <a href="/temas"
                    class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                    Temas
                    <span
                        class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>

                <a href="/noticias"
                    class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                    Noticias
                    <span
                        class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>

                {{-- 👈 Enlace Agenda (condicional) --}}
                @if ($canSeeAgenda)
                    <a href="{{ route('agenda.index') }}"
                        class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                        Agenda
                        <span
                            class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                    </a>
                @endif

                <a href="/contacto"
                    class="group relative py-7 text-xs font-bold uppercase tracking-[0.12em] text-slate-800 transition hover:text-blue-700">
                    Contacto
                    <span
                        class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-blue-700 transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>

                {{-- Botón búsqueda --}}
                <button type="button" @click="searchOpen = true"
                    class="ml-2 flex h-10 w-10 items-center justify-center border border-slate-300 text-slate-700 transition hover:border-blue-700 hover:bg-blue-700 hover:text-white"
                    aria-label="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z" />
                    </svg>
                </button>

                {{-- 👈 NUEVO: Icono de sesión --}}
                @auth
                    {{-- Usuario logueado: mostrar avatar/nombre + dropdown --}}
                    <div x-data="{ userMenu: false }" class="relative ml-2">
                        <button type="button" @click="userMenu = !userMenu"
                            class="flex h-10 items-center gap-2 border border-slate-300 px-3 text-slate-700 transition hover:border-blue-700 hover:bg-blue-700 hover:text-white"
                            aria-label="Menú de usuario">
                            @if (auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}"
                                    class="h-6 w-6 rounded-full object-cover">
                            @else
                                <div
                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-950 text-[10px] font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="userMenu" @click.outside="userMenu = false" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 top-full mt-2 w-64 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-xl">

                            <div class="border-b border-slate-100 px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Sesión iniciada
                                </p>
                                <p class="mt-1 truncate text-sm font-bold text-slate-900">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="truncate text-xs text-slate-500">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <div class="py-1">
                                <a href="/admin"
                                    class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Panel de administración
                                </a>

                                <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-3 px-4 py-2 text-left text-sm text-red-600 transition hover:bg-red-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Usuario NO logueado: mostrar icono de login --}}
                    <a href="{{ route('filament.admin.auth.login') }}"
                        class="ml-2 flex h-10 w-10 items-center justify-center border border-slate-300 text-slate-700 transition hover:border-blue-700 hover:bg-blue-700 hover:text-white"
                        aria-label="Iniciar sesión" title="Iniciar sesión">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @endauth

            </nav>


            {{-- Botón móvil --}}
            <button type="button" @click="open = !open"
                class="relative flex h-11 w-11 items-center justify-center border border-slate-300 text-slate-800 lg:hidden"
                :aria-expanded="open" aria-label="Abrir menú">

                <span class="absolute h-0.5 w-5 bg-current transition duration-300"
                    :class="open ? 'rotate-45' : '-translate-y-1.5'"></span>

                <span class="absolute h-0.5 w-5 bg-current transition duration-300"
                    :class="open ? '-rotate-45' : 'translate-y-1.5'"></span>

            </button>

        </div>

    </div>


    {{-- Menú móvil --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="border-b border-slate-200 bg-white shadow-xl lg:hidden">

        <nav class="mx-auto max-w-7xl px-6 py-6">

            <a href="/" @click="open = false"
                class="block border-b border-slate-100 py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                Inicio
            </a>

            <a href="/perfil" @click="open = false"
                class="block border-b border-slate-100 py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                Jorge Pinto
            </a>

            <a href="/temas" @click="open = false"
                class="block border-b border-slate-100 py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                Temas
            </a>

            <a href="/noticias" @click="open = false"
                class="block border-b border-slate-100 py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                Noticias
            </a>

            {{-- 👈 Agenda móvil (condicional) --}}
            @if ($canSeeAgenda)
                <a href="{{ route('agenda.index') }}" @click="open = false"
                    class="block border-b border-slate-100 py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                    Agenda
                </a>
            @endif

            <a href="/contacto" @click="open = false"
                class="block py-4 text-sm font-bold uppercase tracking-wider text-slate-900">
                Contacto
            </a>

            {{-- 👈 Icono de sesión en móvil --}}
            @auth
                <div class="mt-4 border-t border-slate-200 pt-4">
                    <div class="flex items-center gap-3 px-4 py-2">
                        @if (auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}"
                                class="h-10 w-10 rounded-full object-cover">
                        @else
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-950 text-sm font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <a href="/admin" @click="open = false"
                        class="mt-2 block rounded-lg bg-slate-950 px-4 py-3 text-center text-sm font-bold uppercase tracking-wider text-white">
                        Ir al panel
                    </a>

                    <form method="POST" action="{{ route('filament.admin.auth.logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-lg border border-red-200 px-4 py-3 text-center text-sm font-bold uppercase tracking-wider text-red-600 transition hover:bg-red-50">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('filament.admin.auth.login') }}" @click="open = false"
                    class="mt-4 block rounded-lg bg-slate-950 px-4 py-3 text-center text-sm font-bold uppercase tracking-wider text-white">
                    Iniciar sesión
                </a>
            @endauth

        </nav>

    </div>


    {{-- Buscador --}}
    <div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] bg-slate-950/95 backdrop-blur-md"
        @keydown.escape.window="searchOpen = false">

        <div class="mx-auto max-w-5xl px-6 pt-32">

            <div class="flex items-center justify-between">

                <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                    Buscar en el sitio
                </p>

                <button type="button" @click="searchOpen = false"
                    class="flex h-10 w-10 items-center justify-center border border-white/30 text-white transition hover:bg-white hover:text-slate-950"
                    aria-label="Cerrar búsqueda">
                    ×
                </button>

            </div>


            <form action="/buscar" method="GET" class="mt-10">

                <div class="flex border-b-2 border-white/40 focus-within:border-blue-400">

                    <input type="search" name="q" placeholder="¿Qué estás buscando?"
                        class="min-w-0 flex-1 bg-transparent px-0 py-5 text-3xl font-bold text-white outline-none placeholder:text-white/40 md:text-5xl">

                    <button type="submit" class="px-4 text-white transition hover:text-blue-400"
                        aria-label="Buscar">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z" />
                        </svg>

                    </button>

                </div>

            </form>


            <p class="mt-6 text-sm text-white/50">
                Presiona ESC para cerrar
            </p>

        </div>

    </div>

</header>
