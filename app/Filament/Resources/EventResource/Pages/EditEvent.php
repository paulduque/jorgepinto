<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Redirigir al listado de eventos después de guardar cambios.
     */
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
