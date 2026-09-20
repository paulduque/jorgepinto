<?php

namespace App\Filament\Resources\SemanaPlanResource\Pages;

use App\Filament\Resources\SemanaPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSemanaPlans extends ListRecords
{
    protected static string $resource = SemanaPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
