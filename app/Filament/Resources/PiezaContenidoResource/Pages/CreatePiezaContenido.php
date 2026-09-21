<?php

namespace App\Filament\Resources\PiezaContenidoResource\Pages;

use App\Filament\Resources\PiezaContenidoResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePiezaContenido extends CreateRecord
{
    protected static string $resource = PiezaContenidoResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
