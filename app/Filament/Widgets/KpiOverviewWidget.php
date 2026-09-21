<?php

namespace App\Filament\Widgets;

use App\Models\AvanceKpi;
use App\Models\KpiSemanal;
use App\Models\SemanaPlan;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class KpiOverviewWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.kpi-overview';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    // Estado del modal
    public ?int $kpiSemanalId = null;
    public ?string $avanceValor = null;
    public ?string $avanceNotas = null;
    public bool $modalAbierto = false;

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

    public function getKpis(): array
    {
        $semana = $this->getSemanaActual();

        if (! $semana) {
            return [];
        }

        $kpis = KpiSemanal::where('semana_id', $semana->id)->get()->keyBy('kpi');
        $hoy = now()->format('Y-m-d');

        $config = [
            'contactos' => ['icon' => 'heroicon-o-user-group', 'label' => 'Contactos captados', 'color' => 'blue'],
            'validadores' => ['icon' => 'heroicon-o-star', 'label' => 'Validadores activos', 'color' => 'amber'],
            'suscriptores' => ['icon' => 'heroicon-o-chat-bubble-left-right', 'label' => 'Suscriptores WhatsApp', 'color' => 'green'],
            'alcance' => ['icon' => 'heroicon-o-megaphone', 'label' => 'Alcance semanal', 'color' => 'purple'],
            'eventos' => ['icon' => 'heroicon-o-flag', 'label' => 'Eventos cubiertos', 'color' => 'rose'],
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

            $avanceHoy = AvanceKpi::where('kpi_semanal_id', $kpi->id)
                ->whereDate('fecha', $hoy)
                ->first();

            $resultado[] = [
                'id' => $kpi->id,
                'key' => $key,
                'icon' => $meta['icon'],
                'label' => $meta['label'],
                'color' => $meta['color'],
                'valor' => $valor,
                'meta' => $metaValor,
                'cumplimiento' => $cumplimiento,
                'notas' => $kpi->notas,
                'avance_hoy' => $avanceHoy ? (float) $avanceHoy->valor : null,
                'registrado_hoy' => $avanceHoy !== null,
                'avance_hoy_id' => $avanceHoy?->id,
            ];
        }

        return $resultado;
    }

    public function getSemanaActual(): ?SemanaPlan
    {
        return SemanaPlan::where('estado', 'en_curso')->first()
            ?? SemanaPlan::orderBy('fecha_inicio')->first();
    }

    /**
     * Abrir el modal para registrar/editar el avance del día.
     */
    public function abrirModal(int $kpiSemanalId): void
    {
        $this->kpiSemanalId = $kpiSemanalId;
        $this->avanceValor = null;
        $this->avanceNotas = null;

        // Si ya existe un avance hoy, precargarlo
        $existente = AvanceKpi::where('kpi_semanal_id', $kpiSemanalId)
            ->whereDate('fecha', now())
            ->first();

        if ($existente) {
            $this->avanceValor = (string) $existente->valor;
            $this->avanceNotas = $existente->notas;
        }

        $this->modalAbierto = true;
    }

    /**
     * Cerrar el modal.
     */
    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
        $this->kpiSemanalId = null;
        $this->avanceValor = null;
        $this->avanceNotas = null;
    }

    /**
     * Guardar o actualizar el avance del día.
     */
    public function guardarAvance(): void
    {
        if (! $this->kpiSemanalId) {
            return;
        }

        $this->validate([
            'avanceValor' => 'required|numeric|min:0',
        ]);

        $user = Filament::auth()->user();

        // Buscar si ya existe un avance hoy para este KPI
        $avance = AvanceKpi::where('kpi_semanal_id', $this->kpiSemanalId)
            ->whereDate('fecha', now())
            ->first();

        if ($avance) {
            // Actualizar
            $avance->update([
                'valor' => $this->avanceValor,
                'notas' => $this->avanceNotas,
            ]);
        } else {
            // Crear
            AvanceKpi::create([
                'kpi_semanal_id' => $this->kpiSemanalId,
                'fecha' => now(),
                'valor' => $this->avanceValor,
                'notas' => $this->avanceNotas,
                'created_by' => $user?->id,
            ]);
        }

        // Notificación
        Notification::make()
            ->title('Avance registrado')
            ->body('El KPI se ha actualizado correctamente.')
            ->success()
            ->send();

        $this->cerrarModal();

        // Refrescar el widget
        $this->dispatch('$refresh');
    }

    protected function getForms(): array
    {
        return [];
    }
}
