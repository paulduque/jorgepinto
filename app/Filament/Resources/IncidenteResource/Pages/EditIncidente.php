<?php

namespace App\Filament\Resources\IncidenteResource\Pages;

use App\Filament\Resources\IncidenteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncidente extends EditRecord
{
    protected static string $resource = IncidenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
