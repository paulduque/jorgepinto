<?php

namespace App\Filament\Resources\DocumentoCampanaResource\Pages;

use App\Filament\Resources\DocumentoCampanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocumento extends EditRecord
{
    protected static string $resource = DocumentoCampanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Ver documento'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
