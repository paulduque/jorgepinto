<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filement\Forms\Components\Select;
use Filement\Forms\Components\DateTimePicker;
use Filement\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Agenda';

    protected static ?string $modelLabel = 'Evento';

    protected static ?string $pluralModelLabel = 'Eventos';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();

        if (! $user) {
            return false;
        }

        // Recargar el modelo desde la BD
        $user = User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->hasAnyRole(['super_admin', 'coordinador']);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canViewAny(): bool
    {
        return static::canAccess();
    }

    public static function canCreate(): bool
    {
        return static::canAccess();
    }

    public static function canEdit($record): bool
    {
        return static::canAccess();
    }

    public static function canDelete($record): bool
    {
        return static::canAccess();
    }

    public static function canDeleteAny(): bool
    {
        return static::canAccess();
    }

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del evento')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Se genera automáticamente desde el título.'),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Imagen del evento')
                            ->image()
                            ->disk('public')
                            ->directory('events')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9'])
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1600)
                            ->imageResizeTargetHeight(900)
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state) {
                                Log::info('Imagen actualizada', ['state' => $state]);
                            }),

                        Forms\Components\Select::make('type')
                            ->label('Tipo de evento')
                            ->options([
                                'mitin' => 'Mitin',
                                'reunion' => 'Reunión',
                                'entrevista' => 'Entrevista',
                                'gira' => 'Gira',
                                'tarea' => 'Tarea',
                                'otro' => 'Otro',
                            ])
                            ->required()
                            ->default('reunion'),

                        Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'planificado' => 'Planificado',
                                'en_curso' => 'En curso',
                                'completado' => 'Completado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required()
                            ->default('planificado'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fecha y hora')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_at')
                            ->label('Inicio')
                            ->required()
                            ->seconds(false)
                            ->native(false),

                        Forms\Components\DateTimePicker::make('end_at')
                            ->label('Fin')
                            ->seconds(false)
                            ->native(false)
                            ->after('start_at'),

                        Forms\Components\Toggle::make('all_day')
                            ->label('Todo el día')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ubicación')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->label('Lugar')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitud')
                            ->numeric()
                            ->step(0.0000001),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitud')
                            ->numeric()
                            ->step(0.0000001),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Visibilidad')
                    ->schema([
                        Forms\Components\Toggle::make('is_public')
                            ->label('Evento público')
                            ->helperText('Si está activo, el evento será visible en la agenda pública.')
                            ->default(false),

                        Forms\Components\ColorPicker::make('color')
                            ->label('Color en el calendario')
                            ->default('#3b82f6'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Responsables asignados')
                    ->schema([
                        Forms\Components\Select::make('assignedUsers')
                            ->label('Usuarios asignados')
                            ->relationship('assignedUsers', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    // ─────────────────────────────────────────────────────────
    // TABLA
    // ─────────────────────────────────────────────────────────
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'mitin' => 'Mitin',
                        'reunion' => 'Reunión',
                        'entrevista' => 'Entrevista',
                        'gira' => 'Gira',
                        'tarea' => 'Tarea',
                        'otro' => 'Otro',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'mitin' => 'danger',
                        'reunion' => 'info',
                        'entrevista' => 'warning',
                        'gira' => 'success',
                        'tarea' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('start_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lugar')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'planificado' => 'Planificado',
                        'en_curso' => 'En curso',
                        'completado' => 'Completado',
                        'cancelado' => 'Cancelado',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'planificado' => 'info',
                        'en_curso' => 'warning',
                        'completado' => 'success',
                        'cancelado' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),

                Tables\Columns\TextColumn::make('assignedUsers.name')
                    ->label('Responsables')
                    ->badge()
                    ->separator(',')
                    ->limitList(2),
            ])
            ->defaultSort('start_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'mitin' => 'Mitin',
                        'reunion' => 'Reunión',
                        'entrevista' => 'Entrevista',
                        'gira' => 'Gira',
                        'tarea' => 'Tarea',
                        'otro' => 'Otro',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'planificado' => 'Planificado',
                        'en_curso' => 'En curso',
                        'completado' => 'Completado',
                        'cancelado' => 'Cancelado',
                    ]),

                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Público'),

                Tables\Filters\Filter::make('start_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Desde'),
                        Forms\Components\DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('start_at', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('start_at', '<=', $date));
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
