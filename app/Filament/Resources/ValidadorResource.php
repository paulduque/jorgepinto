<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidadorResource\Pages;
use App\Models\Validador;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ValidadorResource extends Resource
{
    protected static ?string $model = Validador::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Validadores';

    protected static ?string $modelLabel = 'Validador';

    protected static ?string $pluralModelLabel = 'Validadores';

    protected static ?string $slug = 'validadores';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 5;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del validador')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre completo')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('cargo')
                            ->label('Cargo o rol')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Ej: Presidente de junta parroquial, Dirigente barrial, Transportista'),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(30),

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
                                'contactado' => 'Contactado',
                                'comprometido' => 'Comprometido',
                                'activo' => 'Activo',
                                'inactivo' => 'Inactivo',
                            ])
                            ->required()
                            ->default('contactado'),

                        Forms\Components\DatePicker::make('fecha_apoyo')
                            ->label('Fecha de apoyo')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\Textarea::make('notas')
                            ->label('Notas')
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
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('cargo')
                    ->label('Cargo')
                    ->searchable()
                    ->wrap()
                    ->limit(40)
                    ->tooltip(fn($record) => $record->cargo),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->placeholder('—')
                    ->toggleable(),

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
                        'contactado' => 'Contactado',
                        'comprometido' => 'Comprometido',
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'contactado' => 'gray',
                        'comprometido' => 'warning',
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_apoyo')
                    ->label('Fecha apoyo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),
            ])
            ->defaultSort('estado', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'contactado' => 'Contactado',
                        'comprometido' => 'Comprometido',
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                    ]),

                Tables\Filters\SelectFilter::make('zona_id')
                    ->label('Zona')
                    ->relationship('zona', 'canton')
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
            'index' => Pages\ListValidadores::route('/'),
            'create' => Pages\CreateValidador::route('/create'),
            'edit' => Pages\EditValidador::route('/{record}/edit'),
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
