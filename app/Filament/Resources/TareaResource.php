<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TareaResource\Pages;
use App\Models\SemanaPlan;
use App\Models\Tarea;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TareaResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationLabel = 'Tareas';

    protected static ?string $modelLabel = 'Tarea';

    protected static ?string $pluralModelLabel = 'Tareas';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 4;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la tarea')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('semana_id')
                            ->label('Semana del plan')
                            ->relationship('semana', 'codigo')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\TextInput::make('fase')
                            ->label('Fase')
                            ->maxLength(100)
                            ->helperText('Ej: S1, S2, Cierre'),

                        Forms\Components\Select::make('responsable_id')
                            ->label('Responsable')
                            ->relationship('responsable', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\DatePicker::make('fecha_limite')
                            ->label('Fecha límite')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'en_curso' => 'En curso',
                                'completada' => 'Completada',
                                'bloqueada' => 'Bloqueada',
                            ])
                            ->required()
                            ->default('pendiente'),

                        Forms\Components\Select::make('prioridad')
                            ->label('Prioridad')
                            ->options([
                                'alta' => 'Alta',
                                'media' => 'Media',
                                'baja' => 'Baja',
                            ])
                            ->required()
                            ->default('media'),

                        Forms\Components\TextInput::make('orden')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
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
                    ->label('Tarea')
                    ->searchable()
                    ->wrap()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('semana.codigo')
                    ->label('Semana')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('fase')
                    ->label('Fase')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\SelectColumn::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_curso' => 'En curso',
                        'completada' => 'Completada',
                        'bloqueada' => 'Bloqueada',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('prioridad')
                    ->label('Prioridad')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'alta' => 'Alta',
                        'media' => 'Media',
                        'baja' => 'Baja',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'alta' => 'danger',
                        'media' => 'warning',
                        'baja' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('responsable.name')
                    ->label('Responsable')
                    ->badge()
                    ->placeholder('Sin asignar')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('fecha_limite')
                    ->label('Límite')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->color(fn($record) => $record->fecha_limite && $record->fecha_limite->isPast() && $record->estado !== 'completada' ? 'danger' : null),
            ])
            ->defaultSort('orden', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'en_curso' => 'En curso',
                        'completada' => 'Completada',
                        'bloqueada' => 'Bloqueada',
                    ]),

                Tables\Filters\SelectFilter::make('prioridad')
                    ->label('Prioridad')
                    ->options([
                        'alta' => 'Alta',
                        'media' => 'Media',
                        'baja' => 'Baja',
                    ]),

                Tables\Filters\SelectFilter::make('semana_id')
                    ->label('Semana')
                    ->relationship('semana', 'codigo')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListTareas::route('/'),
            'create' => Pages\CreateTarea::route('/create'),
            'edit' => Pages\EditTarea::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['semana', 'responsable']);
    }
}
