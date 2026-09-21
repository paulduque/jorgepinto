<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncidenteResource\Pages;
use App\Models\Incidente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IncidenteResource extends Resource
{
    protected static ?string $model = Incidente::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Incidentes';

    protected static ?string $modelLabel = 'Incidente';

    protected static ?string $pluralModelLabel = 'Incidentes';

    protected static ?string $slug = 'incidentes';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 9;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del incidente')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de incidente')
                            ->options([
                                'ataque' => 'Ataque',
                                'desinformacion' => 'Desinformación',
                                'crisis' => 'Crisis',
                                'otro' => 'Otro',
                            ])
                            ->required()
                            ->default('ataque'),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'abierto' => 'Abierto',
                                'en_proceso' => 'En proceso',
                                'resuelto' => 'Resuelto',
                            ])
                            ->required()
                            ->default('abierto'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción del incidente')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Qué pasó, dónde, quién lo generó, alcance'),

                        Forms\Components\Textarea::make('respuesta')
                            ->label('Respuesta oficial')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Cómo se respondió, por qué canal, con qué argumentos'),
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
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'ataque' => 'Ataque',
                        'desinformacion' => 'Desinformación',
                        'crisis' => 'Crisis',
                        'otro' => 'Otro',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'ataque' => 'danger',
                        'desinformacion' => 'warning',
                        'crisis' => 'danger',
                        'otro' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60)
                    ->tooltip(fn($record) => $record->descripcion)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'abierto' => 'Abierto',
                        'en_proceso' => 'En proceso',
                        'resuelto' => 'Resuelto',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'abierto' => 'danger',
                        'en_proceso' => 'warning',
                        'resuelto' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('tiene_respuesta')
                    ->label('Respuesta')
                    ->state(fn($record) => ! empty($record->respuesta))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'abierto' => 'Abierto',
                        'en_proceso' => 'En proceso',
                        'resuelto' => 'Resuelto',
                    ]),

                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'ataque' => 'Ataque',
                        'desinformacion' => 'Desinformación',
                        'crisis' => 'Crisis',
                        'otro' => 'Otro',
                    ]),

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
            'index' => Pages\ListIncidentes::route('/'),
            'create' => Pages\CreateIncidente::route('/create'),
            'edit' => Pages\EditIncidente::route('/{record}/edit'),
        ];
    }
}
