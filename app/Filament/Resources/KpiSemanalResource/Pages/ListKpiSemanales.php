<?php

namespace App\Filament\Resources\KpiSemanalResource\Pages;

use App\Filament\Resources\KpiSemanalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiSemanales extends ListRecords
{
    protected static string $resource = KpiSemanalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
