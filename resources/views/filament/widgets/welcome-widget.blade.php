<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">

            {{-- Imagen de bienvenida --}}
            @if ($settings?->welcome_image)
                <div class="overflow-hidden rounded-xl">
                    <img src="{{ asset('storage/' . $settings->welcome_image) }}" alt="Bienvenido"
                        class="aspect-[16/9] w-full object-cover">
                </div>
            @else
                <div
                    class="flex aspect-[16/9] w-full items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 text-white">
                    <div class="text-center">
                        <div class="text-6xl">👋</div>
                        <p class="mt-4 text-xl font-bold">Bienvenido</p>
                    </div>
                </div>
            @endif

            {{-- Mensaje de bienvenida --}}
            <div class="text-center">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">
                    ¡Hola, {{ $user->name }}!
                </h2>

                @if ($settings?->person_name)
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                        Bienvenido al panel de administración de {{ $settings->person_name }}
                    </p>
                @endif

                @if ($settings?->list_number)
                    <p class="mt-1 text-sm font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                        {{ $settings->list_number }}
                    </p>
                @endif

                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <x-filament::button tag="a" href="/" icon="heroicon-o-home" color="primary"
                        size="lg">
                        Ir al sitio web
                    </x-filament::button>

                    <x-filament::button tag="a" href="{{ route('filament.admin.auth.profile') }}"
                        icon="heroicon-o-user-circle" color="gray" size="lg" outlined>
                        Mi perfil
                    </x-filament::button>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
