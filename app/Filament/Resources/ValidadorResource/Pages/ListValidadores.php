<?php

namespace App\Filament\Resources\ValidadorResource\Pages;

use App\Filament\Resources\ValidadorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidadores extends ListRecords
{
    protected static string $resource = ValidadorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
