<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactoResource\Pages;
use App\Models\Contacto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactoResource extends Resource
{
    protected static ?string $model = Contacto::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Contactos';

    protected static ?string $modelLabel = 'Contacto';

    protected static ?string $pluralModelLabel = 'Contactos';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 7;

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del contacto')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre completo')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono')
                            ->required()
                            ->tel()
                            ->maxLength(30),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\Select::make('zona_id')
                            ->label('Zona')
                            ->relationship('zona', 'canton')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->nombre_completo)
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\Select::make('origen')
                            ->label('Origen')
                            ->options([
                                'evento' => 'Evento',
                                'qr' => 'QR',
                                'whatsapp' => 'WhatsApp',
                                'referido' => 'Referido',
                                'otro' => 'Otro',
                            ])
                            ->required()
                            ->default('evento'),

                        Forms\Components\Select::make('capturado_por')
                            ->label('Capturado por')
                            ->relationship('capturadoPor', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Quién del equipo captó este contacto'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Consentimiento')
                    ->schema([
                        Forms\Components\Toggle::make('consentimiento')
                            ->label('Consentimiento digital (por escrito o vía web)')
                            ->helperText('El simpatizante firmó o aceptó explícitamente')
                            ->default(false)
                            ->live(),

                        Forms\Components\Toggle::make('consentimiento_verbal')
                            ->label('Consentimiento verbal')
                            ->helperText('El simpatizante dio permiso verbalmente')
                            ->default(false)
                            ->live(),

                        Forms\Components\DateTimePicker::make('fecha_consentimiento')
                            ->label('Fecha de consentimiento')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->visible(fn(Forms\Get $get) => $get('consentimiento') || $get('consentimiento_verbal')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Notas')
                    ->schema([
                        Forms\Components\Textarea::make('notas')
                            ->label('Notas adicionales')
                            ->rows(3)
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
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('zona.canton')
                    ->label('Zona')
                    ->badge()
                    ->color('info')
                    ->placeholder('Sin zona')
                    ->sortable(),

                Tables\Columns\TextColumn::make('origen')
                    ->label('Origen')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'evento' => 'Evento',
                        'qr' => 'QR',
                        'whatsapp' => 'WhatsApp',
                        'referido' => 'Referido',
                        'otro' => 'Otro',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'evento' => 'success',
                        'qr' => 'info',
                        'whatsapp' => 'success',
                        'referido' => 'warning',
                        'otro' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('consentimiento')
                    ->label('Consent.')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('consentimiento_verbal')
                    ->label('Verbal')
                    ->boolean()
                    ->trueIcon('heroicon-o-chat-bubble-left-right')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('capturadoPor.name')
                    ->label('Capturado por')
                    ->badge()
                    ->color('primary')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('zona_id')
                    ->label('Zona')
                    ->relationship('zona', 'canton')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('origen')
                    ->label('Origen')
                    ->options([
                        'evento' => 'Evento',
                        'qr' => 'QR',
                        'whatsapp' => 'WhatsApp',
                        'referido' => 'Referido',
                        'otro' => 'Otro',
                    ]),

                Tables\Filters\TernaryFilter::make('consentimiento')
                    ->label('Consentimiento digital')
                    ->placeholder('Todos')
                    ->trueLabel('Solo con consentimiento')
                    ->falseLabel('Solo sin consentimiento'),

                Tables\Filters\TernaryFilter::make('consentimiento_verbal')
                    ->label('Consentimiento verbal')
                    ->placeholder('Todos')
                    ->trueLabel('Solo con consentimiento verbal')
                    ->falseLabel('Solo sin consentimiento verbal'),
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
            'index' => Pages\ListContactos::route('/'),
            'create' => Pages\CreateContacto::route('/create'),
            'edit' => Pages\EditContacto::route('/{record}/edit'),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // CONSULTAS
    // ─────────────────────────────────────────────────────────
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['zona', 'capturadoPor']);
    }
}
