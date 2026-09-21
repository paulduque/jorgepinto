<?php

namespace App\Filament\Widgets;

use App\Models\SemanaPlan;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;

class ProgresoFasesChart extends ChartWidget
{
    protected static ?string $heading = 'Progreso de tareas por semana';

    protected static ?string $description = 'Tareas completadas vs pendientes por semana del plan';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

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
        $semanas = SemanaPlan::orderBy('fecha_inicio')->get();

        $completadas = [];
        $enProgreso = [];
        $pendientes = [];
        $labels = [];

        foreach ($semanas as $semana) {
            $labels[] = $semana->codigo;

            $tareas = $semana->tareas();

            $completadas[] = (clone $tareas)->where('estado', 'completada')->count();
            $enProgreso[] = (clone $tareas)->where('estado', 'en_curso')->count();
            $pendientes[] = (clone $tareas)->whereIn('estado', ['pendiente', 'bloqueada'])->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Completadas',
                    'data' => $completadas,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                ],
                [
                    'label' => 'En progreso',
                    'data' => $enProgreso,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#f59e0b',
                ],
                [
                    'label' => 'Pendientes',
                    'data' => $pendientes,
                    'backgroundColor' => '#e5e7eb',
                    'borderColor' => '#d1d5db',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
