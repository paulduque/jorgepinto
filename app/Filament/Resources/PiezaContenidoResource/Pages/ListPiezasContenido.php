<?php

namespace App\Filament\Resources\PiezaContenidoResource\Pages;

use App\Filament\Resources\PiezaContenidoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPiezasContenido extends ListRecords
{
    protected static string $resource = PiezaContenidoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Crear pieza'),
        ];
    }
}
