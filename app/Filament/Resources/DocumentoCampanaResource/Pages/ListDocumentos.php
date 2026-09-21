<?php

namespace App\Filament\Resources\DocumentoCampanaResource\Pages;

use App\Filament\Resources\DocumentoCampanaResource;
use Filament\Resources\Pages\ListRecords;

class ListDocumentos extends ListRecords
{
    protected static string $resource = DocumentoCampanaResource::class;

    protected function getHeaderActions(): array
    {
        return []; // Sin acción de crear (documento único)
    }
}
