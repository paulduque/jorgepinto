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
