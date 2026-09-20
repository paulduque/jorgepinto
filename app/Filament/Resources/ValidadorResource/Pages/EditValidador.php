<?php

namespace App\Filament\Resources\ValidadorResource\Pages;

use App\Filament\Resources\ValidadorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidador extends EditRecord
{
    protected static string $resource = ValidadorResource::class;

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
