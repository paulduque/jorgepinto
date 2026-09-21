<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiSemanalResource\Pages;
use App\Models\KpiSemanal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KpiSemanalResource extends Resource
{
    protected static ?string $model = KpiSemanal::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'KPIs Semanales';

    protected static ?string $modelLabel = 'KPI';

    protected static ?string $pluralModelLabel = 'KPIs Semanales';

    protected static ?string $slug = 'kpis-semanales';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 6;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del KPI')
                    ->schema([
                        Forms\Components\Select::make('semana_id')
                            ->label('Semana')
                            ->relationship('semana', 'codigo')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('kpi')
                            ->label('KPI')
                            ->options([
                                'alcance' => 'Alcance semanal (personas)',
                                'suscriptores' => 'Suscriptores Canal WhatsApp',
                                'contactos' => 'Contactos captados',
                                'validadores' => 'Validadores activos',
                                'eventos' => 'Eventos cubiertos',
                                'reconocimiento' => 'Reconocimiento de nombre (%)',
                            ])
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('valor')
                            ->label('Valor')
                            ->numeric()
                            ->required()
                            ->default(0),

                        Forms\Components\TextInput::make('meta')
                            ->label('Meta')
                            ->numeric()
                            ->nullable(),

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
                Tables\Columns\TextColumn::make('semana.codigo')
                    ->label('Semana')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kpi')
                    ->label('KPI')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'alcance' => 'Alcance',
                        'suscriptores' => 'Suscriptores',
                        'contactos' => 'Contactos',
                        'validadores' => 'Validadores',
                        'eventos' => 'Eventos',
                        'reconocimiento' => 'Reconocimiento',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'alcance' => 'info',
                        'suscriptores' => 'success',
                        'contactos' => 'warning',
                        'validadores' => 'primary',
                        'eventos' => 'gray',
                        'reconocimiento' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('valor')
                    ->label('Valor')
                    ->numeric(decimalPlaces: 0)
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('meta')
                    ->label('Meta')
                    ->numeric(decimalPlaces: 0)
                    ->placeholder('—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cumplimiento')
                    ->label('Cumplimiento')
                    ->state(fn($record) => $record->cumplimiento !== null ? $record->cumplimiento . '%' : '—')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state === '—' => 'gray',
                        (float) $state >= 100 => 'success',
                        (float) $state >= 70 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('notas')
                    ->label('Notas')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),
            ])
            ->defaultSort('semana_id', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('semana_id')
                    ->label('Semana')
                    ->relationship('semana', 'codigo')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('kpi')
                    ->label('KPI')
                    ->options([
                        'alcance' => 'Alcance',
                        'suscriptores' => 'Suscriptores',
                        'contactos' => 'Contactos',
                        'validadores' => 'Validadores',
                        'eventos' => 'Eventos',
                        'reconocimiento' => 'Reconocimiento',
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
            'index' => Pages\ListKpiSemanales::route('/'),
            'create' => Pages\CreateKpiSemanal::route('/create'),
            'edit' => Pages\EditKpiSemanal::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['semana']);
    }
}
