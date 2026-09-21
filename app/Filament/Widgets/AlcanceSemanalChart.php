<?php

namespace App\Filament\Widgets;

use App\Models\KpiSemanal;
use App\Models\SemanaPlan;
use Filament\Widgets\ChartWidget;

class AlcanceSemanalChart extends ChartWidget
{
    protected static ?string $heading = 'Progreso semanal de metas';

    protected static ?string $description = 'Evolución de las metas (contactos, validadores, suscriptores) semana a semana';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '320px';

    public static function canView(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();

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

        $contactos = [];
        $validadores = [];
        $suscriptores = [];
        $labels = [];

        foreach ($semanas as $semana) {
            $labels[] = $semana->codigo;

            $kpis = KpiSemanal::where('semana_id', $semana->id)->get()->keyBy('kpi');

            $contactos[] = (float) ($kpis->get('contactos')?->meta ?? 0);
            $validadores[] = (float) ($kpis->get('validadores')?->meta ?? 0);
            $suscriptores[] = (float) ($kpis->get('suscriptores')?->meta ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Contactos',
                    'data' => $contactos,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Validadores',
                    'data' => $validadores,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Suscriptores WhatsApp',
                    'data' => $suscriptores,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
                'y' => [
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
