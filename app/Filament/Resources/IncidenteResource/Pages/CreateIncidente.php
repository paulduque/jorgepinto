<?php

namespace App\Filament\Resources\IncidenteResource\Pages;

use App\Filament\Resources\IncidenteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncidente extends CreateRecord
{
    protected static string $resource = IncidenteResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
