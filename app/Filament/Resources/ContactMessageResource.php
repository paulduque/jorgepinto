<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Mensajes';

    protected static ?string $modelLabel = 'mensaje';

    protected static ?string $pluralModelLabel = 'mensajes';

    protected static ?string $navigationGroup = 'Contacto';

    protected static ?int $navigationSort = 1;

    /**
     * Mostrar el contador de mensajes nuevos en el sidebar.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::where('status', 'nuevo')->count();
        return $count > 0 ? (string) $count : null;
    }

    /**
     * Color del badge.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del remitente')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                            ->copyable(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->disabled()
                            ->copyable()
                            ->placeholder('No proporcionado'),

                        Forms\Components\TextInput::make('subject')
                            ->label('Asunto')
                            ->disabled()
                            ->placeholder('Sin asunto')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Mensaje')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('')
                            ->disabled()
                            ->rows(10)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Metadatos')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP')
                            ->disabled(),

                        Forms\Components\TextInput::make('status')
                            ->label('Estado')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Recibido')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('consent_given_at')
                            ->label('Consentimiento LOPDP')
                            ->disabled(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')
                    ->label('')
                    ->icon(fn(string $state): string => match ($state) {
                        'nuevo' => 'heroicon-o-envelope',
                        'leido' => 'heroicon-o-envelope-open',
                        'respondido' => 'heroicon-o-check-circle',
                        'archivado' => 'heroicon-o-archive-box',
                        default => 'heroicon-o-envelope',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'nuevo' => 'danger',
                        'leido' => 'info',
                        'respondido' => 'success',
                        'archivado' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('Sin asunto'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'nuevo' => 'Nuevo',
                        'leido' => 'Leído',
                        'respondido' => 'Respondido',
                        'archivado' => 'Archivado',
                        default => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'nuevo' => 'danger',
                        'leido' => 'info',
                        'respondido' => 'success',
                        'archivado' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'nuevo' => 'Nuevo',
                        'leido' => 'Leído',
                        'respondido' => 'Respondido',
                        'archivado' => 'Archivado',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Desde'),
                        Forms\Components\DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('markAsRead')
                    ->label('Marcar como leído')
                    ->icon('heroicon-o-envelope-open')
                    ->color('info')
                    ->visible(fn(ContactMessage $record): bool => $record->status === 'nuevo')
                    ->action(function (ContactMessage $record) {
                        $record->markAsRead();
                    }),

                Tables\Actions\Action::make('markAsReplied')
                    ->label('Marcar como respondido')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(ContactMessage $record): bool => in_array($record->status, ['nuevo', 'leido']))
                    ->action(function (ContactMessage $record) {
                        $record->update(['status' => 'respondido']);
                    }),

                Tables\Actions\Action::make('archive')
                    ->label('Archivar')
                    ->icon('heroicon-o-archive-box')
                    ->color('gray')
                    ->visible(fn(ContactMessage $record): bool => $record->status !== 'archivado')
                    ->action(function (ContactMessage $record) {
                        $record->update(['status' => 'archivado']);
                    })
                    ->requiresConfirmation(),

                Tables\Actions\ViewAction::make()
                    ->label('Ver'),

                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Marcar como leídos')
                        ->icon('heroicon-o-envelope-open')
                        ->color('info')
                        ->action(fn($records) => $records->each->update(['status' => 'leido']))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('archive')
                        ->label('Archivar')
                        ->icon('heroicon-o-archive-box')
                        ->color('gray')
                        ->action(fn($records) => $records->each->update(['status' => 'archivado']))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }

    /**
     * No permitir crear mensajes desde el panel.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
