<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
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

                        Select::make('type')
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

                        Select::make('status')
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

                Section::make('Fecha y hora')
                    ->schema([
                        DateTimePicker::make('start_at')
                            ->label('Inicio')
                            ->required()
                            ->seconds(false)
                            ->native(false),

                        DateTimePicker::make('end_at')
                            ->label('Fin')
                            ->seconds(false)
                            ->native(false)
                            ->after('start_at'),

                        Toggle::make('all_day')
                            ->label('Todo el día')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Ubicación')
                    ->schema([
                        TextInput::make('location')
                            ->label('Lugar')
                            ->maxLength(255),

                        TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(255),

                        TextInput::make('latitude')
                            ->label('Latitud')
                            ->numeric()
                            ->step(0.0000001),

                        TextInput::make('longitude')
                            ->label('Longitud')
                            ->numeric()
                            ->step(0.0000001),
                    ])
                    ->columns(2),

                Section::make('Visibilidad')
                    ->schema([
                        Toggle::make('is_public')
                            ->label('Evento público')
                            ->helperText('Si está activo, el evento será visible en la agenda pública.')
                            ->default(false),

                        ColorPicker::make('color')
                            ->label('Color en el calendario')
                            ->default('#3b82f6'),
                    ])
                    ->columns(2),

                Section::make('Responsables asignados')
                    ->schema([
                        Select::make('assignedUsers')
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
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('description')
                    ->label('Descripción / Notas')
                    ->limit(60)
                    ->tooltip(fn($state) => $state)
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('type')
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

                TextColumn::make('start_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lugar')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('status')
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

                IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),

                TextColumn::make('assignedUsers.name')
                    ->label('Responsables')
                    ->badge()
                    ->separator(',')
                    ->limitList(2),
            ])
            ->defaultSort('start_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'mitin' => 'Mitin',
                        'reunion' => 'Reunión',
                        'entrevista' => 'Entrevista',
                        'gira' => 'Gira',
                        'tarea' => 'Tarea',
                        'otro' => 'Otro',
                    ]),

                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'planificado' => 'Planificado',
                        'en_curso' => 'En curso',
                        'completado' => 'Completado',
                        'cancelado' => 'Cancelado',
                    ]),

                TernaryFilter::make('is_public')
                    ->label('Público'),

                Filter::make('start_at')
                    ->form([
                        DatePicker::make('from')->label('Desde'),
                        DatePicker::make('until')->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('start_at', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('start_at', '<=', $date));
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->recordUrl(fn($record) => static::getUrl('view', ['record' => $record]))
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
