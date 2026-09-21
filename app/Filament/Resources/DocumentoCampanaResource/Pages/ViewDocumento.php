<?php

namespace App\Filament\Resources\DocumentoCampanaResource\Pages;

use App\Filament\Resources\DocumentoCampanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocumento extends ViewRecord
{
    protected static string $resource = DocumentoCampanaResource::class;

    protected static string $view = 'filament.documento-campana';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Editar documento'),
        ];
    }

    protected function getViewData(): array
    {
        $record = $this->record;

        return [
            'titulo' => $record->titulo,
            'version' => $record->version,
            'contenido' => $record->contenido,
            'updated_at' => $record->updated_at?->translatedFormat('d \d\e F \d\e Y'),
            'record_id' => $record->id,
        ];
    }
}
