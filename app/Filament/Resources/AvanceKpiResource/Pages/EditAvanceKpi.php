<?php

namespace App\Filament\Resources\AvanceKpiResource\Pages;

use App\Filament\Resources\AvanceKpiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvanceKpi extends EditRecord
{
    protected static string $resource = AvanceKpiResource::class;

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
