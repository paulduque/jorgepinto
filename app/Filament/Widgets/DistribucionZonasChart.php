<?php

namespace App\Filament\Widgets;

use App\Models\Zona;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class DistribucionZonasChart extends ChartWidget
{
    protected static ?string $heading = 'Contactos por zona';

    protected static ?string $description = 'Distribución de contactos captados por cantón';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 1;

    protected static ?string $maxHeight = '320px';

    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        if (! $user) {
            return false;
        }

        if (! method_exists($user, 'hasAnyRole')) {
            return false;
        }

        return $user->hasAnyRole(['super_admin', 'coordinador', 'analista', 'candidato']);
    }

    protected function getData(): array
    {
        $zonas = Zona::withCount('contactos')
            ->whereHas('contactos')
            ->orderBy('contactos_count', 'desc')
            ->get();

        // Si no hay contactos, mostrar todas las zonas con 0
        if ($zonas->isEmpty()) {
            $zonas = Zona::orderBy('canton')->get();

            return [
                'datasets' => [
                    [
                        'data' => array_fill(0, max($zonas->count(), 1), 1),
                        'backgroundColor' => array_fill(0, max($zonas->count(), 1), '#e5e7eb'),
                    ],
                ],
                'labels' => $zonas->pluck('canton')->toArray() ?: ['Sin contactos'],
            ];
        }

        $colores = [
            '#3b82f6',
            '#10b981',
            '#f59e0b',
            '#ef4444',
            '#8b5cf6',
            '#ec4899',
            '#06b6d4',
            '#f97316',
            '#84cc16',
            '#6366f1',
            '#14b8a6',
            '#a855f7',
        ];

        $data = $zonas->pluck('contactos_count')->toArray();
        $labels = $zonas->pluck('canton')->toArray();
        $backgrounds = [];

        foreach ($zonas as $i => $zona) {
            $backgrounds[] = $colores[$i % count($colores)];
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $backgrounds,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'right',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
