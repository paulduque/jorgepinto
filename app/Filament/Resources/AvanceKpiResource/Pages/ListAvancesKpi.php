<?php

namespace App\Filament\Resources\AvanceKpiResource\Pages;

use App\Filament\Resources\AvanceKpiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvancesKpi extends ListRecords
{
    protected static string $resource = AvanceKpiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Registrar avance'),
        ];
    }
}
