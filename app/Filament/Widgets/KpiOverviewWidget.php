<?php

namespace App\Filament\Widgets;

use App\Models\KpiSemanal;
use App\Models\SemanaPlan;
use Filament\Widgets\Widget;

class KpiOverviewWidget extends Widget
{
    protected static string $view = 'filament.widgets.kpi-overview';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    /**
     * Solo visible para super_admin, coordinador, analista.
     */
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

    /**
     * Carga los KPIs de la semana actual.
     */
    public function getKpis(): array
    {
        // Buscar la semana en curso
        $semana = SemanaPlan::where('estado', 'en_curso')->first()
            ?? SemanaPlan::orderBy('fecha_inicio')->first();

        if (! $semana) {
            return [];
        }

        $kpis = KpiSemanal::where('semana_id', $semana->id)->get()->keyBy('kpi');

        // Configuración visual de cada KPI
        $config = [
            'contactos' => [
                'icon' => 'heroicon-o-user-group',
                'label' => 'Contactos captados',
                'color' => 'blue',
            ],
            'validadores' => [
                'icon' => 'heroicon-o-star',
                'label' => 'Validadores activos',
                'color' => 'amber',
            ],
            'suscriptores' => [
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'label' => 'Suscriptores WhatsApp',
                'color' => 'green',
            ],
            'alcance' => [
                'icon' => 'heroicon-o-megaphone',
                'label' => 'Alcance semanal',
                'color' => 'purple',
            ],
            'eventos' => [
                'icon' => 'heroicon-o-flag',
                'label' => 'Eventos cubiertos',
                'color' => 'rose',
            ],
        ];

        $resultado = [];

        foreach ($config as $key => $meta) {
            $kpi = $kpis->get($key);

            if (! $kpi) {
                continue;
            }

            $valor = (float) $kpi->valor;
            $metaValor = (float) $kpi->meta;
            $cumplimiento = $metaValor > 0 ? round(($valor / $metaValor) * 100, 1) : 0;

            $resultado[] = [
                'key' => $key,
                'icon' => $meta['icon'],
                'label' => $meta['label'],
                'color' => $meta['color'],
                'valor' => $valor,
                'meta' => $metaValor,
                'cumplimiento' => $cumplimiento,
                'notas' => $kpi->notas,
            ];
        }

        return $resultado;
    }

    /**
     * Devuelve la semana actual para mostrarla en el header.
     */
    public function getSemanaActual(): ?SemanaPlan
    {
        return SemanaPlan::where('estado', 'en_curso')->first()
            ?? SemanaPlan::orderBy('fecha_inicio')->first();
    }
}
