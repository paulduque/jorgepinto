<?php

namespace App\Filament\Resources\SemanaPlanResource\Pages;

use App\Filament\Resources\SemanaPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSemanaPlan extends CreateRecord
{
    protected static string $resource = SemanaPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
