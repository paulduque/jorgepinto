<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZonaResource\Pages;
use App\Models\Zona;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ZonaResource extends Resource
{
    protected static ?string $model = Zona::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Zonas';

    protected static ?string $modelLabel = 'Zona';

    protected static ?string $pluralModelLabel = 'Zonas';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 9;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la zona')
                    ->schema([
                        Forms\Components\TextInput::make('canton')
                            ->label('Cantón')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('parroquia')
                            ->label('Parroquia')
                            ->maxLength(100)
                            ->helperText('Opcional. Si la zona es todo el cantón, dejar vacío.'),

                        Forms\Components\Select::make('prioridad')
                            ->label('Prioridad')
                            ->options([
                                'alta' => 'Alta',
                                'media' => 'Media',
                                'baja' => 'Baja',
                            ])
                            ->required()
                            ->default('media'),

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
                Tables\Columns\TextColumn::make('canton')
                    ->label('Cantón')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('parroquia')
                    ->label('Parroquia')
                    ->searchable()
                    ->placeholder('—'),

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

                Tables\Columns\TextColumn::make('contactos_count')
                    ->label('Contactos')
                    ->counts('contactos')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('validadores_count')
                    ->label('Validadores')
                    ->counts('validadores')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('canton', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('prioridad')
                    ->label('Prioridad')
                    ->options([
                        'alta' => 'Alta',
                        'media' => 'Media',
                        'baja' => 'Baja',
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
            'index' => Pages\ListZonas::route('/'),
            'create' => Pages\CreateZona::route('/create'),
            'edit' => Pages\EditZona::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['contactos', 'validadores']);
    }
}
