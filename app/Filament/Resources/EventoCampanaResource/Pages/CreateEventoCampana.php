<?php

namespace App\Filament\Resources\EventoCampanaResource\Pages;

use App\Filament\Resources\EventoCampanaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventoCampana extends CreateRecord
{
    protected static string $resource = EventoCampanaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
