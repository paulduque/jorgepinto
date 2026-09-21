<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PiezaContenidoResource\Pages;
use App\Models\PiezaContenido;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PiezaContenidoResource extends Resource
{
    protected static ?string $model = PiezaContenido::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Piezas de Contenido';

    protected static ?string $modelLabel = 'Pieza';

    protected static ?string $pluralModelLabel = 'Piezas de Contenido';

    protected static ?string $slug = 'piezas-contenido';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 8;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la pieza')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha de publicación')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        Forms\Components\Select::make('formato')
                            ->label('Formato')
                            ->options([
                                'reel' => 'Reel',
                                'post' => 'Post',
                                'story' => 'Story',
                                'video' => 'Video',
                                'carrusel' => 'Carrusel',
                            ])
                            ->required()
                            ->default('post'),

                        Forms\Components\Select::make('zona_id')
                            ->label('Zona')
                            ->relationship('zona', 'canton')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_completo)
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Zona objetivo de la pieza (opcional)'),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'borrador' => 'Borrador',
                                'aprobado' => 'Aprobado',
                                'programado' => 'Programado',
                                'publicado' => 'Publicado',
                            ])
                            ->required()
                            ->default('borrador'),

                        Forms\Components\Textarea::make('mensaje')
                            ->label('Mensaje / Contenido')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('url')
                            ->label('URL de la publicación')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://...')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Métricas')
                    ->schema([
                        Forms\Components\TextInput::make('alcance')
                            ->label('Alcance')
                            ->numeric()
                            ->default(0)
                            ->helperText('Personas alcanzadas'),

                        Forms\Components\TextInput::make('interacciones')
                            ->label('Interacciones')
                            ->numeric()
                            ->default(0)
                            ->helperText('Likes, comentarios, compartidos'),
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

                Tables\Columns\TextColumn::make('formato')
                    ->label('Formato')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'reel' => 'Reel',
                        'post' => 'Post',
                        'story' => 'Story',
                        'video' => 'Video',
                        'carrusel' => 'Carrusel',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'reel' => 'danger',
                        'post' => 'info',
                        'story' => 'warning',
                        'video' => 'success',
                        'carrusel' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('mensaje')
                    ->label('Mensaje')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->mensaje)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('zona.canton')
                    ->label('Zona')
                    ->badge()
                    ->color('info')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'borrador' => 'Borrador',
                        'aprobado' => 'Aprobado',
                        'programado' => 'Programado',
                        'publicado' => 'Publicado',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'borrador' => 'gray',
                        'aprobado' => 'info',
                        'programado' => 'warning',
                        'publicado' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('alcance')
                    ->label('Alcance')
                    ->numeric(decimalPlaces: 0)
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('interacciones')
                    ->label('Interacciones')
                    ->numeric(decimalPlaces: 0)
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('tasa_interaccion')
                    ->label('Tasa Interacción')
                    ->state(fn($record) => $record->tasa_interaccion . '%')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        (float) $state >= 5 => 'success',
                        (float) $state >= 1.5 => 'warning',
                        default => 'danger',
                    })
                    ->tooltip('Porcentaje de personas que interactuaron (likes, comentarios, compartidos) sobre el total que vio la pieza. Fórmula: (Interacciones ÷ Alcance) × 100. Referencia: ≥5% excelente, 1.5-5% aceptable, <1.5% bajo.')
                    ->sortable(),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'aprobado' => 'Aprobado',
                        'programado' => 'Programado',
                        'publicado' => 'Publicado',
                    ]),

                Tables\Filters\SelectFilter::make('formato')
                    ->label('Formato')
                    ->options([
                        'reel' => 'Reel',
                        'post' => 'Post',
                        'story' => 'Story',
                        'video' => 'Video',
                        'carrusel' => 'Carrusel',
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
            'index' => Pages\ListPiezasContenido::route('/'),
            'create' => Pages\CreatePiezaContenido::route('/create'),
            'edit' => Pages\EditPiezaContenido::route('/{record}/edit'),
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
