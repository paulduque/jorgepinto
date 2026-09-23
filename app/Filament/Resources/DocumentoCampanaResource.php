<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentoCampanaResource\Pages;
use App\Models\DocumentoCampana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentoCampanaResource extends Resource
{
    protected static ?string $model = DocumentoCampana::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Documento Maestro';

    protected static ?string $modelLabel = 'Documento';

    protected static ?string $pluralModelLabel = 'Documento Maestro';

    protected static ?string $slug = 'documento-maestro';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false; // Solo se edita el documento existente
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    // ─────────────────────────────────────────────────────────
    // FORMULARIO
    // ─────────────────────────────────────────────────────────
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del documento')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('version')
                            ->label('Versión')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Forms\Components\Select::make('updated_by')
                            ->label('Actualizado por')
                            ->relationship('updatedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenido (Markdown)')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('contenido')
                            ->label('')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h1',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                                'table',
                                'redo',
                                'undo',
                            ]),
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
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('version')
                    ->label('Versión')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->label('Actualizado por')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListDocumentos::route('/'),
            'view' => Pages\ViewDocumento::route('/{record}'),
            'edit' => Pages\EditDocumento::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['updatedBy']);
    }
}
