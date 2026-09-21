<?php

namespace App\Observers;

use App\Models\AvanceKpi;
use App\Models\KpiSemanal;

class AvanceKpiObserver
{
    /**
     * Al crear, actualizar o eliminar un avance, recalcular el valor total
     * del KPI semanal correspondiente.
     */
    public function saved(AvanceKpi $avance): void
    {
        $this->recalcular($avance->kpi_semanal_id);
    }

    public function deleted(AvanceKpi $avance): void
    {
        $this->recalcular($avance->kpi_semanal_id);
    }

    /**
     * Suma todos los avances del KPI semanal y actualiza su campo 'valor'.
     */
    protected function recalcular(int $kpiSemanalId): void
    {
        $kpi = KpiSemanal::find($kpiSemanalId);

        if (! $kpi) {
            return;
        }

        $total = AvanceKpi::where('kpi_semanal_id', $kpiSemanalId)->sum('valor');

        $kpi->update(['valor' => $total]);
    }
}
