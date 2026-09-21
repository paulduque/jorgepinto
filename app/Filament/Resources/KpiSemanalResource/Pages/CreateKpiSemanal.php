<?php

namespace App\Filament\Resources\KpiSemanalResource\Pages;

use App\Filament\Resources\KpiSemanalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKpiSemanal extends CreateRecord
{
    protected static string $resource = KpiSemanalResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
