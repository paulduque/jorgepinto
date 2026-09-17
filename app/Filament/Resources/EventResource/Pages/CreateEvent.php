<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    /**
     * Redirigir al listado de eventos después de crear.
     */
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
