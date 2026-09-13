<?php

namespace App\Filament\Widgets;

use App\Models\Hero;
use App\Models\News;
use App\Models\Theme;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $activeHero = Hero::where('is_active', true)->first();

        $lastNews = News::where('is_published', true)
            ->latest('published_at')
            ->first();

        return [
            Stat::make('Noticias publicadas', News::where('is_published', true)->count())
                ->icon('heroicon-o-newspaper')
                ->color('success'),

            Stat::make('Temas activos', Theme::where('is_active', true)->count())
                ->icon('heroicon-o-tag')
                ->color('warning'),

            Stat::make('Portada', $activeHero ? 'Activa' : 'Sin configurar')
                ->icon('heroicon-o-photo')
                ->color($activeHero ? 'success' : 'danger'),

            Stat::make('Última noticia', $lastNews?->published_at?->format('d/m/Y') ?? 'Sin noticias')
                ->icon('heroicon-o-calendar')
                ->color('gray'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
