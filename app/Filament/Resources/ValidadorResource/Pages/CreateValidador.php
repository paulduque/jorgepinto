<?php

namespace App\Filament\Resources\ValidadorResource\Pages;

use App\Filament\Resources\ValidadorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateValidador extends CreateRecord
{
    protected static string $resource = ValidadorResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
