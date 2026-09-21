<?php

namespace App\Filament\Resources\PiezaContenidoResource\Pages;

use App\Filament\Resources\PiezaContenidoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPiezaContenido extends EditRecord
{
    protected static string $resource = PiezaContenidoResource::class;

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
