<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemanaPlanResource\Pages;
use App\Models\SemanaPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SemanaPlanResource extends Resource
{
    protected static ?string $model = SemanaPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Semanas del Plan';

    protected static ?string $modelLabel = 'Semana';

    protected static ?string $pluralModelLabel = 'Semanas del Plan';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 10;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la semana')
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->helperText('Ej: S1, S2, ..., Cierre, Oficial, Silencio'),

                        Forms\Components\TextInput::make('fase')
                            ->label('Fase')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\DatePicker::make('fecha_inicio')
                            ->label('Fecha de inicio')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\DatePicker::make('fecha_fin')
                            ->label('Fecha de fin')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->after('fecha_inicio'),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'en_curso' => 'En curso',
                                'completada' => 'Completada',
                            ])
                            ->required()
                            ->default('pendiente'),

                        Forms\Components\Textarea::make('objetivo')
                            ->label('Objetivo de la semana')
                            ->rows(3)
                            ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Semana')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->label('Inicio')
                    ->date('d/m')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_fin')
                    ->label('Fin')
                    ->date('d/m')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fase')
                    ->label('Fase')
                    ->searchable()
                    ->wrap()
                    ->limit(50)
                    ->tooltip(fn($record) => $record->fase),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pendiente' => 'Pendiente',
                        'en_curso' => 'En curso',
                        'completada' => 'Completada',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'pendiente' => 'gray',
                        'en_curso' => 'warning',
                        'completada' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tareas_count')
                    ->label('Tareas')
                    ->counts('tareas')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('kpis_count')
                    ->label('KPIs')
                    ->counts('kpis')
                    ->badge()
                    ->color('success'),
            ])
            ->defaultSort('fecha_inicio', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_curso' => 'En curso',
                        'completada' => 'Completada',
                    ]),
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
            'index' => Pages\ListSemanaPlans::route('/'),
            'create' => Pages\CreateSemanaPlan::route('/create'),
            'edit' => Pages\EditSemanaPlan::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['tareas', 'kpis']);
    }
}
