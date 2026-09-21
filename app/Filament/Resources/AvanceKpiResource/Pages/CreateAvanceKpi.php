<?php

namespace App\Filament\Resources\AvanceKpiResource\Pages;

use App\Filament\Resources\AvanceKpiResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAvanceKpi extends CreateRecord
{
    protected static string $resource = AvanceKpiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Filament::auth()->id();
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    /**
     * Pre-rellena el kpi_semanal_id si viene por query string.
     */
    public function mount(): void
    {
        parent::mount();

        $kpiId = request()->query('kpi_semanal_id');

        if ($kpiId) {
            $this->form->fill([
                'kpi_semanal_id' => $kpiId,
                'fecha' => now()->format('Y-m-d'),
                'valor' => 0,
            ]);
        }
    }
}
