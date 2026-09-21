<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventoCampanaResource\Pages;
use App\Models\EventoCampana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventoCampanaResource extends Resource
{
    protected static ?string $model = EventoCampana::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'Eventos de Campo';

    protected static ?string $modelLabel = 'Evento';

    protected static ?string $pluralModelLabel = 'Eventos de Campo';

    protected static ?string $slug = 'eventos-campana';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 7;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del evento')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título del evento')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Select::make('zona_id')
                            ->label('Zona')
                            ->relationship('zona', 'canton')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_completo)
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'planificado' => 'Planificado',
                                'realizado' => 'Realizado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required()
                            ->default('planificado'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Métricas del evento')
                    ->schema([
                        Forms\Components\TextInput::make('contactos_captados')
                            ->label('Contactos captados')
                            ->numeric()
                            ->default(0)
                            ->helperText('Cuántos contactos se captaron en este evento'),

                        Forms\Components\TextInput::make('piezas_publicadas')
                            ->label('Piezas publicadas')
                            ->numeric()
                            ->default(0)
                            ->helperText('Cuántas piezas de contenido se publicaron'),
                    ])
                    ->columns(2),
            ]);
    }

    // ─────────────────────────────────────────────────────────
    // TABLA
    // ─────────────────────────────────────────────────────────
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Evento')
                    ->searchable()
                    ->wrap()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('zona.canton')
                    ->label('Zona')
                    ->badge()
                    ->color('info')
                    ->placeholder('Sin zona')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'planificado' => 'Planificado',
                        'realizado' => 'Realizado',
                        'cancelado' => 'Cancelado',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'planificado' => 'warning',
                        'realizado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('contactos_captados')
                    ->label('Contactos')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('piezas_publicadas')
                    ->label('Piezas')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'planificado' => 'Planificado',
                        'realizado' => 'Realizado',
                        'cancelado' => 'Cancelado',
                    ]),

                Tables\Filters\SelectFilter::make('zona_id')
                    ->label('Zona')
                    ->relationship('zona', 'canton')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde')
                            ->native(false),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['desde'], fn($q, $date) => $q->whereDate('fecha', '>=', $date))
                            ->when($data['hasta'], fn($q, $date) => $q->whereDate('fecha', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ─────────────────────────────────────────────────────────
    // RELACIONES
    // ─────────────────────────────────────────────────────────
    public static function getRelations(): array
    {
        return [];
    }

    // ─────────────────────────────────────────────────────────
    // PÁGINAS
    // ─────────────────────────────────────────────────────────
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventosCampana::route('/'),
            'create' => Pages\CreateEventoCampana::route('/create'),
            'edit' => Pages\EditEventoCampana::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['zona']);
    }
}
