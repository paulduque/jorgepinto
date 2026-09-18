<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('markAsRead')
                ->label('Marcar como leído')
                ->icon('heroicon-o-envelope-open')
                ->color('info')
                ->visible(fn() => $this->record->status === 'nuevo')
                ->action(function () {
                    $this->record->markAsRead();
                    $this->refreshFormData(['status', 'read_at']);
                }),

            Actions\Action::make('markAsReplied')
                ->label('Marcar como respondido')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn() => in_array($this->record->status, ['nuevo', 'leido']))
                ->action(function () {
                    $this->record->update(['status' => 'respondido']);
                    $this->refreshFormData(['status']);
                }),

            Actions\Action::make('replyEmail')
                ->label('Responder por email')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('primary')
                ->url(fn() => 'mailto:' . $this->record->email . '?subject=Re: ' . ($this->record->subject ?? 'Tu mensaje'))
                ->openUrlInNewTab(),

            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Marcar como leído automáticamente al abrir.
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);

        if ($this->record->status === 'nuevo') {
            $this->record->markAsRead();
        }
    }
}
