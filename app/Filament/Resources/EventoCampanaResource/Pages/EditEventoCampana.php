<?php

namespace App\Filament\Resources\EventoCampanaResource\Pages;

use App\Filament\Resources\EventoCampanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventoCampana extends EditRecord
{
    protected static string $resource = EventoCampanaResource::class;

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
