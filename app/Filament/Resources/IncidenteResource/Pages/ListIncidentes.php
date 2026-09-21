<?php

namespace App\Filament\Resources\IncidenteResource\Pages;

use App\Filament\Resources\IncidenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentes extends ListRecords
{
    protected static string $resource = IncidenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Registrar incidente'),
        ];
    }
}
