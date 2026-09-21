<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvanceKpiResource\Pages;
use App\Models\AvanceKpi;
use App\Models\KpiSemanal;
use App\Models\SemanaPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AvanceKpiResource extends Resource
{
    protected static ?string $model = AvanceKpi::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Avances de KPIs';

    protected static ?string $modelLabel = 'Avance';

    protected static ?string $pluralModelLabel = 'Avances de KPIs';

    protected static ?string $slug = 'avances-kpi';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 10;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar avance')
                    ->schema([
                        Forms\Components\Select::make('kpi_semanal_id')
                            ->label('KPI semanal')
                            ->options(
                                KpiSemanal::with('semana')
                                    ->get()
                                    ->mapWithKeys(function ($kpi) {
                                        $label = "{$kpi->semana?->codigo} · " . ucfirst($kpi->kpi) . " (meta: " . number_format($kpi->meta, 0, ',', '.') . ")";
                                        return [$kpi->id => $label];
                                    })
                                    ->toArray()
                            )
                            ->searchable()
                            ->required()
                            ->helperText('Selecciona el KPI al que quieres registrar avance')
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('fecha')
                            ->label('Fecha del avance')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->helperText('Un solo avance por día por KPI'),

                        Forms\Components\TextInput::make('valor')
                            ->label('Avance del día')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->helperText('Cuánto avanzaste hoy en este KPI'),

                        Forms\Components\Textarea::make('notas')
                            ->label('Notas')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Contexto del avance (opcional)'),
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

                Tables\Columns\TextColumn::make('kpiSemanal.semana.codigo')
                    ->label('Semana')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kpiSemanal.kpi')
                    ->label('KPI')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'contactos' => 'info',
                        'validadores' => 'warning',
                        'suscriptores' => 'success',
                        'alcance' => 'primary',
                        'eventos' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('valor')
                    ->label('Avance')
                    ->numeric(decimalPlaces: 0)
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('kpiSemanal.meta')
                    ->label('Meta semanal')
                    ->numeric(decimalPlaces: 0)
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('kpiSemanal.valor')
                    ->label('Acumulado')
                    ->numeric(decimalPlaces: 0)
                    ->badge()
                    ->color(fn($record) => $record->kpiSemanal?->cumplimiento >= 100 ? 'success' : 'warning')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('notas')
                    ->label('Notas')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->notas)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Registrado por')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('kpi_semanal_id')
                    ->label('KPI')
                    ->options(
                        KpiSemanal::with('semana')
                            ->get()
                            ->mapWithKeys(fn($kpi) => [
                                $kpi->id => "{$kpi->semana?->codigo} · " . ucfirst($kpi->kpi),
                            ])
                            ->toArray()
                    )
                    ->searchable(),

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
            'index' => Pages\ListAvancesKpi::route('/'),
            'create' => Pages\CreateAvanceKpi::route('/create'),
            'edit' => Pages\EditAvanceKpi::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['kpiSemanal.semana', 'createdBy']);
    }
}
