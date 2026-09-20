<?php

namespace App\Filament\Resources\TareaResource\Pages;

use App\Filament\Resources\TareaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarea extends EditRecord
{
    protected static string $resource = TareaResource::class;

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
