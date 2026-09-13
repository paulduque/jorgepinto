<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Accesos rápidos
        </x-slot>

        <div class="flex flex-wrap gap-3">
            <x-filament::button tag="a" :href="\App\Filament\Resources\NewsResource::getUrl('create')" icon="heroicon-o-plus">
                Nueva Noticia
            </x-filament::button>

            @php
                $activeHero = \App\Models\Hero::where('is_active', true)->first();
            @endphp

            @if ($activeHero)
                <x-filament::button tag="a" color="gray" :href="\App\Filament\Resources\HeroResource::getUrl('edit', ['record' => $activeHero])" icon="heroicon-o-photo">
                    Editar Portada
                </x-filament::button>
            @endif

            @php
                $settings = \App\Models\SiteSetting::current();
            @endphp

            @if ($settings)
                <x-filament::button tag="a" color="gray" :href="\App\Filament\Resources\SiteSettingResource::getUrl('edit', ['record' => $settings])" icon="heroicon-o-cog-6-tooth">
                    Configuración del Sitio
                </x-filament::button>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
