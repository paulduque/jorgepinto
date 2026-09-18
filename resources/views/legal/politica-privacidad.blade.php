@extends('layouts.app')

@section('title', 'Política de Privacidad | Jorge Pinto')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-slate-950 py-24 md:py-32">
        {{-- Decoración --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
        <div class="absolute -right-40 -top-40 h-96 w-96 rounded-full bg-blue-600/10 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-blue-400/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-4xl px-6">
            <div class="flex items-center gap-4">
                <span class="h-1 w-12 bg-blue-400"></span>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-300 md:text-sm">
                    Información legal
                </p>
            </div>

            <h1 class="mt-6 text-4xl font-black leading-[1.05] tracking-[-0.03em] text-white md:text-6xl">
                Política de Privacidad
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 md:text-lg">
                Conoce cómo protegemos y tratamos tus datos personales de acuerdo con la
                Ley Orgánica de Protección de Datos Personales del Ecuador.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-4 text-sm text-slate-400">
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Actualizado: {{ now()->translatedFormat('d \d\e F \d\e Y') }}
                </span>

                <span class="hidden h-4 w-px bg-slate-700 md:block"></span>

                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Cumple con LOPDP
                </span>
            </div>
        </div>
    </section>

    {{-- Índice de contenido --}}
    <section class="border-b border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-4xl px-6 py-8">
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                Contenido
            </p>

            <nav class="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (['1. Información general', '2. Responsable del tratamiento', '3. Datos que recopilamos', '4. Finalidad del tratamiento', '5. Base legal', '6. Conservación de los datos', '7. Compartición de datos', '8. Sus derechos (ARCO)', '9. Seguridad de los datos', '10. Cookies', '11. Modificaciones', '12. Aceptación'] as $index => $item)
                    <a href="#seccion-{{ $index + 1 }}"
                        class="group flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-blue-700">
                        <span
                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white text-xs font-bold text-slate-400 ring-1 ring-slate-200 transition group-hover:bg-blue-700 group-hover:text-white group-hover:ring-blue-700">
                            {{ $index + 1 }}
                        </span>
                        {{ substr($item, 3) }}
                    </a>
                @endforeach
            </nav>
        </div>
    </section>

    {{-- Contenido principal --}}
    <article class="bg-white py-16 md:py-24">
        <div class="mx-auto max-w-4xl px-6">

            <div class="space-y-12">

                {{-- 1. Información general --}}
                <section id="seccion-1" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            1
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Información general
                        </h2>
                    </div>

                    <div class="mt-6 space-y-4 pl-14 text-base leading-8 text-slate-700">
                        <p>
                            La presente Política de Privacidad regula el tratamiento de los datos personales
                            que los usuarios proporcionan a través del sitio web oficial de
                            <strong
                                class="font-bold text-slate-950">{{ $settings?->person_name ?? 'Jorge Pinto' }}</strong>,
                            en cumplimiento de la <strong class="font-bold text-slate-950">Ley Orgánica de Protección de
                                Datos Personales (LOPDP)</strong>
                            y su Reglamento General, vigentes en la República del Ecuador.
                        </p>
                        <p>
                            Al utilizar este sitio web y proporcionar sus datos personales, el usuario
                            acepta las prácticas descritas en esta Política de Privacidad.
                        </p>
                    </div>
                </section>

                {{-- 2. Responsable --}}
                <section id="seccion-2" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            2
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Responsable del tratamiento
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <dl class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Responsable</dt>
                                <dd class="mt-1 font-semibold text-slate-950">{{ $settings?->person_name ?? 'Jorge Pinto' }}
                                </dd>
                            </div>

                            @if ($settings?->email)
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Email</dt>
                                    <dd class="mt-1">
                                        <a href="mailto:{{ $settings->email }}"
                                            class="font-semibold text-blue-700 hover:underline">
                                            {{ $settings->email }}
                                        </a>
                                    </dd>
                                </div>
                            @endif

                            @if ($settings?->phone)
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Teléfono</dt>
                                    <dd class="mt-1">
                                        <a href="tel:{{ $settings->phone }}"
                                            class="font-semibold text-blue-700 hover:underline">
                                            {{ $settings->phone }}
                                        </a>
                                    </dd>
                                </div>
                            @endif

                            @if ($settings?->address)
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-500">Dirección</dt>
                                    <dd class="mt-1 font-semibold text-slate-950">{{ $settings->address }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </section>

                {{-- 3. Datos --}}
                <section id="seccion-3" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            3
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Datos personales que recopilamos
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            A través de nuestros formularios, podemos recopilar los siguientes datos:
                        </p>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-slate-200 p-5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-bold text-slate-950">Identificación</h3>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">Nombre completo</p>
                            </div>

                            <div class="rounded-lg border border-slate-200 p-5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-bold text-slate-950">Contacto</h3>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">Correo electrónico y número de teléfono
                                </p>
                            </div>

                            <div class="rounded-lg border border-slate-200 p-5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-bold text-slate-950">Navegación</h3>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">Dirección IP, tipo de navegador, sistema
                                    operativo</p>
                            </div>

                            <div class="rounded-lg border border-slate-200 p-5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-bold text-slate-950">Mensaje</h3>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">Contenido del mensaje enviado</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 4. Finalidad --}}
                <section id="seccion-4" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            4
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Finalidad del tratamiento
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Los datos personales recopilados serán utilizados para las siguientes finalidades:
                        </p>

                        <ul class="mt-6 space-y-3">
                            @foreach (['Atender consultas, sugerencias o comentarios enviados por los usuarios', 'Enviar información relacionada con la campaña y sus actividades', 'Mejorar la experiencia de navegación en el sitio web', 'Cumplir con obligaciones legales aplicables'] as $item)
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span class="text-base leading-7 text-slate-700">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- 5. Base legal --}}
                <section id="seccion-5" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            5
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Base legal del tratamiento
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            El tratamiento de sus datos personales se fundamenta en:
                        </p>

                        <div class="mt-6 space-y-3">
                            <div class="rounded-lg border-l-4 border-blue-700 bg-blue-50 p-4">
                                <p class="font-bold text-slate-950">Consentimiento expreso</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">
                                    Otorgado al marcar la casilla de aceptación en nuestros formularios.
                                </p>
                            </div>

                            <div class="rounded-lg border-l-4 border-blue-700 bg-blue-50 p-4">
                                <p class="font-bold text-slate-950">Interés legítimo</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">
                                    Para mejorar nuestros servicios y comunicaciones.
                                </p>
                            </div>

                            <div class="rounded-lg border-l-4 border-blue-700 bg-blue-50 p-4">
                                <p class="font-bold text-slate-950">Cumplimiento legal</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">
                                    Cuando sea requerido por autoridad competente.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 6. Conservación --}}
                <section id="seccion-6" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            6
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Conservación de los datos
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Sus datos personales serán conservados durante el tiempo necesario para cumplir
                            con las finalidades descritas en esta política, o hasta que el usuario solicite
                            su eliminación. Posteriormente, serán eliminados de forma segura.
                        </p>
                    </div>
                </section>

                {{-- 7. Compartición --}}
                <section id="seccion-7" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            7
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Compartición de datos
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <div class="rounded-lg border-l-4 border-amber-500 bg-amber-50 p-5">
                            <p class="text-base leading-7 text-slate-800">
                                <strong class="font-bold">Sus datos personales NO serán compartidos</strong>
                                con terceros sin su consentimiento expreso, salvo en los siguientes casos:
                            </p>
                        </div>

                        <ul class="mt-6 space-y-3">
                            @foreach (['Cuando sea requerido por autoridad judicial o administrativa competente', 'Cuando sea necesario para proteger derechos e intereses legítimos', 'Con proveedores de servicios tecnológicos que actúan como encargados del tratamiento (bajo acuerdos de confidencialidad)'] as $item)
                                <li class="flex items-start gap-3">
                                    <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-slate-400"></span>
                                    <span class="text-base leading-7 text-slate-700">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- 8. Derechos ARCO --}}
                <section id="seccion-8" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            8
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Sus derechos (ARCO)
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            De acuerdo con la LOPDP, usted tiene derecho a:
                        </p>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach ([['Acceso', 'Conocer qué datos personales tenemos sobre usted'], ['Rectificación', 'Solicitar la corrección de datos inexactos'], ['Cancelación', 'Solicitar la eliminación de sus datos'], ['Oposición', 'Oponerse al tratamiento de sus datos'], ['Portabilidad', 'Solicitar sus datos en formato estructurado'], ['Revocación', 'Retirar su consentimiento en cualquier momento']] as $derecho)
                                <div class="rounded-lg border border-slate-200 bg-white p-4">
                                    <p class="font-bold text-slate-950">{{ $derecho[0] }}</p>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">{{ $derecho[1] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 rounded-lg bg-slate-950 p-6 text-white">
                            <p class="text-sm leading-7">
                                Para ejercer estos derechos, puede contactarnos a través de:
                                @if ($settings?->email)
                                    <a href="mailto:{{ $settings->email }}"
                                        class="ml-1 font-bold text-blue-300 hover:text-blue-200">
                                        {{ $settings->email }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </section>

                {{-- 9. Seguridad --}}
                <section id="seccion-9" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            9
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Seguridad de los datos
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Implementamos medidas técnicas y organizativas apropiadas para proteger sus
                            datos personales contra acceso no autorizado, alteración, divulgación o destrucción.
                        </p>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach (['Cifrado de comunicaciones mediante HTTPS', 'Almacenamiento seguro en servidores protegidos', 'Acceso restringido a personal autorizado', 'Verificación anti-spam con reCAPTCHA v3'] as $item)
                                <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <span
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium leading-6 text-slate-700">{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- 10. Cookies --}}
                <section id="seccion-10" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            10
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Cookies
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Este sitio web puede utilizar cookies técnicas necesarias para su correcto
                            funcionamiento. No utilizamos cookies de terceros con fines publicitarios.
                        </p>
                    </div>
                </section>

                {{-- 11. Modificaciones --}}
                <section id="seccion-11" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            11
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Modificaciones a esta política
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier
                            momento. Los cambios serán publicados en esta misma página con la fecha de
                            actualización correspondiente.
                        </p>
                    </div>
                </section>

                {{-- 12. Aceptación --}}
                <section id="seccion-12" class="scroll-mt-24">
                    <div class="flex items-start gap-4">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-700 text-base font-black text-white">
                            12
                        </span>
                        <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 md:text-3xl">
                            Aceptación
                        </h2>
                    </div>

                    <div class="mt-6 pl-14">
                        <p class="text-base leading-8 text-slate-700">
                            Al utilizar este sitio web y enviar información a través de nuestros formularios,
                            usted declara haber leído y comprendido esta Política de Privacidad y acepta
                            sus términos.
                        </p>

                        <div class="mt-8 rounded-2xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6">
                            <div class="flex items-start gap-4">
                                <span
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-700 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-950">¿Tienes preguntas?</p>
                                        <p class="mt-2 text-sm leading-6 text-slate-700">
                                            Si tienes alguna pregunta sobre esta Política de Privacidad o sobre el
                                            tratamiento de tus datos personales, no dudes en contactarnos. Estamos
                                            comprometidos con la protección de tu privacidad.
                                        </p>

                                        <a href="{{ route('contacto') }}"
                                            class="mt-4 inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-blue-700 transition hover:text-blue-900">
                                            Contactar ahora
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            {{-- Botón volver --}}
            <div class="mt-16 border-t border-slate-200 pt-8">
                <a href="{{ route('contacto') }}"
                    class="group inline-flex items-center gap-3 text-sm font-bold uppercase tracking-wide text-slate-950 transition hover:text-blue-700">
                    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a contacto
                </a>
            </div>

        </div>
    </article>

@endsection
