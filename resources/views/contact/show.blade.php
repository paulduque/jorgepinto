@extends('layouts.app')

@section('title', 'Contacto | Jorge Pinto')

@section('content')

    {{-- Encabezado --}}
    <section class="bg-slate-950 text-white">
        <div class="mx-auto max-w-7xl px-6 py-20">

            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-300">
                Jorge Pinto
            </p>

            <h1 class="mt-5 text-5xl font-black tracking-tight md:text-6xl">
                Contacto
            </h1>

            @if ($settings?->contact_description)
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    {{ $settings->contact_description }}
                </p>
            @endif

        </div>
    </section>

    {{-- Información de contacto --}}
    <section class="bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-6">

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

                @if ($settings?->phone)
                    <div class="bg-white p-8 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                            Teléfono
                        </p>

                        <a href="tel:{{ $settings->phone }}"
                            class="mt-4 block font-semibold text-slate-900 hover:text-blue-700">
                            {{ $settings->phone }}
                        </a>
                    </div>
                @endif

                @if ($settings?->whatsapp)
                    <div class="bg-white p-8 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                            WhatsApp
                        </p>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}" target="_blank"
                            rel="noopener" class="mt-4 block font-semibold text-slate-900 hover:text-blue-700">
                            {{ $settings->whatsapp }}
                        </a>
                    </div>
                @endif

                @if ($settings?->email)
                    <div class="bg-white p-8 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                            Email
                        </p>

                        <a href="mailto:{{ $settings->email }}"
                            class="mt-4 block break-words font-semibold text-slate-900 hover:text-blue-700">
                            {{ $settings->email }}
                        </a>
                    </div>
                @endif

                @if ($settings?->address)
                    <div class="bg-white p-8 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">
                            Ubicación
                        </p>

                        <p class="mt-4 font-semibold text-slate-900">
                            {{ $settings->address }}
                        </p>
                    </div>
                @endif

            </div>

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mt-12 rounded-lg border-l-4 border-green-500 bg-green-50 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-green-900">
                                ¡Mensaje enviado!
                            </h3>
                            <p class="mt-1 text-sm text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mt-12 rounded-lg border-l-4 border-red-500 bg-red-50 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-900">
                                Por favor corrige los siguientes errores:
                            </h3>
                            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Formulario de contacto --}}
            <div class="mt-16 grid gap-12 lg:grid-cols-5">

                {{-- Info lateral --}}
                <div class="lg:col-span-2">
                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                        Escríbenos
                    </p>

                    <h2 class="mt-5 text-3xl font-black leading-tight text-slate-950 md:text-4xl">
                        Tu opinión es importante para nosotros
                    </h2>

                    <p class="mt-6 text-base leading-7 text-slate-600">
                        Envíanos tus consultas, propuestas o comentarios. Trabajamos por un futuro mejor para todos y
                        queremos escuchar tu voz.
                    </p>

                    <div class="mt-8 space-y-4 text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-700" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Te responderemos en un plazo de 24-48 horas</span>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-700" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Tus datos están protegidos y no serán compartidos</span>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-700" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>También puedes escribirnos directamente a
                                {{ $settings?->email ?? 'nuestro correo' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Formulario --}}
                <div class="lg:col-span-3">
                    <form action="{{ route('contacto.store') }}" method="POST"
                        class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm md:p-10">
                        @csrf

                        <div class="grid gap-6 md:grid-cols-2">

                            {{-- Nombre --}}
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-slate-700">
                                    Nombre completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 transition focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20 @error('name') border-red-500 @enderror"
                                    placeholder="Tu nombre">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-bold text-slate-700">
                                    Correo electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                    class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 transition focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20 @error('email') border-red-500 @enderror"
                                    placeholder="tu@email.com">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="phone" class="block text-sm font-bold text-slate-700">
                                    Teléfono <span class="text-slate-400">(opcional)</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 transition focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20 @error('phone') border-red-500 @enderror"
                                    placeholder="099 999 9999">
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Asunto --}}
                            <div class="md:col-span-2">
                                <label for="subject" class="block text-sm font-bold text-slate-700">
                                    Asunto <span class="text-slate-400">(opcional)</span>
                                </label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                    class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 transition focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20 @error('subject') border-red-500 @enderror"
                                    placeholder="¿Sobre qué quieres escribirnos?">
                                @error('subject')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Mensaje --}}
                            <div class="md:col-span-2">
                                <label for="message" class="block text-sm font-bold text-slate-700">
                                    Mensaje <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" id="message" rows="6" required
                                    class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-slate-900 transition focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700/20 @error('message') border-red-500 @enderror"
                                    placeholder="Escribe tu mensaje aquí...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Consentimiento LOPDP --}}
                            <div class="md:col-span-2">
                                <label class="flex items-start gap-3">
                                    <input type="checkbox" name="consent_given" value="1" required
                                        {{ old('consent_given') ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-slate-300 text-blue-700 focus:ring-blue-700">
                                    <span class="text-sm leading-6 text-slate-600">
                                        He leído y acepto la
                                        <a href="/politica-privacidad" class="font-semibold text-blue-700 hover:underline"
                                            target="_blank">
                                            política de privacidad
                                        </a>
                                        y autorizo el tratamiento de mis datos personales para recibir una respuesta a mi
                                        consulta. <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                @error('consent_given')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Botón de envío --}}
                        <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-8">
                            <p class="text-xs text-slate-500">
                                <span class="text-red-500">*</span> Campos obligatorios
                            </p>

                            <button type="submit"
                                class="group inline-flex items-center gap-3 rounded-lg bg-blue-700 px-8 py-4 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-blue-800">
                                Enviar mensaje
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            {{-- Redes sociales --}}
            @if ($settings?->facebook || $settings?->instagram || $settings?->twitter || $settings?->youtube || $settings?->tiktok)
                <div class="mt-16 border-t border-slate-200 pt-12">

                    <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-700">
                        Redes sociales
                    </p>

                    <div class="mt-6 flex flex-wrap gap-6">

                        @if ($settings->facebook)
                            <a href="{{ $settings->facebook }}" target="_blank" rel="noopener"
                                class="font-semibold text-slate-900 hover:text-blue-700">
                                Facebook →
                            </a>
                        @endif

                        @if ($settings->instagram)
                            <a href="{{ $settings->instagram }}" target="_blank" rel="noopener"
                                class="font-semibold text-slate-900 hover:text-blue-700">
                                Instagram →
                            </a>
                        @endif

                        @if ($settings->twitter)
                            <a href="{{ $settings->twitter }}" target="_blank" rel="noopener"
                                class="font-semibold text-slate-900 hover:text-blue-700">
                                X / Twitter →
                            </a>
                        @endif

                        @if ($settings->youtube)
                            <a href="{{ $settings->youtube }}" target="_blank" rel="noopener"
                                class="font-semibold text-slate-900 hover:text-blue-700">
                                YouTube →
                            </a>
                        @endif

                        @if ($settings->tiktok)
                            <a href="{{ $settings->tiktok }}" target="_blank" rel="noopener"
                                class="font-semibold text-slate-900 hover:text-blue-700">
                                TikTok →
                            </a>
                        @endif

                    </div>

                </div>
            @endif

        </div>
    </section>

    {{-- Navegación --}}
    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-10">

            <a href="/"
                class="inline-flex items-center text-sm font-bold uppercase tracking-wide text-blue-700 hover:text-blue-900">
                ← Volver al inicio
            </a>

        </div>
    </section>

@endsection
