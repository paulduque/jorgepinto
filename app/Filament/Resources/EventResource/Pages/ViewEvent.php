<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Editar evento'),
            Actions\DeleteAction::make()
                ->label('Eliminar'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información del evento')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Título')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('type')
                            ->label('Tipo')
                            ->badge()
                            ->formatStateUsing(fn($state) => match ($state) {
                                'mitin' => 'Mitin',
                                'reunion' => 'Reunión',
                                'entrevista' => 'Entrevista',
                                'gira' => 'Gira',
                                'tarea' => 'Tarea',
                                'otro' => 'Otro',
                                default => ucfirst($state),
                            })
                            ->color(fn($state) => match ($state) {
                                'mitin' => 'danger',
                                'reunion' => 'info',
                                'entrevista' => 'warning',
                                'gira' => 'success',
                                'tarea' => 'gray',
                                default => 'gray',
                            }),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Estado')
                            ->badge()
                            ->formatStateUsing(fn($state) => match ($state) {
                                'planificado' => 'Planificado',
                                'en_curso' => 'En curso',
                                'completado' => 'Completado',
                                'cancelado' => 'Cancelado',
                                default => ucfirst($state),
                            })
                            ->color(fn($state) => match ($state) {
                                'planificado' => 'info',
                                'en_curso' => 'warning',
                                'completado' => 'success',
                                'cancelado' => 'danger',
                                default => 'gray',
                            }),

                        Infolists\Components\TextEntry::make('is_public')
                            ->label('Evento público')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Sí' : 'No')
                            ->color(fn($state) => $state ? 'success' : 'gray'),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Descripción')
                            ->placeholder('Sin descripción')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Fecha y hora')
                    ->schema([
                        Infolists\Components\TextEntry::make('start_at')
                            ->label('Inicio')
                            ->dateTime('l, d \d\e F \d\e Y - H:i'),

                        Infolists\Components\TextEntry::make('end_at')
                            ->label('Fin')
                            ->dateTime('l, d \d\e F \d\e Y - H:i')
                            ->placeholder('Sin fecha de fin'),

                        Infolists\Components\IconEntry::make('all_day')
                            ->label('Todo el día')
                            ->boolean(),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Ubicación')
                    ->schema([
                        Infolists\Components\TextEntry::make('location')
                            ->label('Lugar')
                            ->placeholder('Sin lugar definido'),

                        Infolists\Components\TextEntry::make('address')
                            ->label('Dirección')
                            ->placeholder('Sin dirección'),

                        Infolists\Components\TextEntry::make('latitude')
                            ->label('Latitud')
                            ->placeholder('—'),

                        Infolists\Components\TextEntry::make('longitude')
                            ->label('Longitud')
                            ->placeholder('—'),
                    ])
                    ->columns(2)
                    ->visible(fn($record) => $record->location || $record->address || $record->latitude),

                Infolists\Components\Section::make('Responsables asignados')
                    ->schema([
                        Infolists\Components\TextEntry::make('assignedUsers.name')
                            ->label('Usuarios')
                            ->badge()
                            ->separator(',')
                            ->placeholder('Sin responsables asignados'),
                    ])
                    ->visible(fn($record) => $record->assignedUsers->isNotEmpty()),

                Infolists\Components\Section::make('Imagen')
                    ->schema([
                        Infolists\Components\ImageEntry::make('image')
                            ->label('')
                            ->disk('public')
                            ->height(300),
                    ])
                    ->visible(fn($record) => $record->image),
            ]);
    }
}
