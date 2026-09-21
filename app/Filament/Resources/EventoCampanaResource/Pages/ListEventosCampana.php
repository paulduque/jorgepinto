<?php

namespace App\Filament\Resources\EventoCampanaResource\Pages;

use App\Filament\Resources\EventoCampanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventosCampana extends ListRecords
{
    protected static string $resource = EventoCampanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear evento'),
        ];
    }
}
