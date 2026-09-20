<?php

namespace App\Filament\Resources\SemanaPlanResource\Pages;

use App\Filament\Resources\SemanaPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSemanaPlan extends EditRecord
{
    protected static string $resource = SemanaPlanResource::class;

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
