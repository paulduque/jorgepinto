<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información principal')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('position')
                            ->label('Cargo / Descripción')
                            ->maxLength(255),

                        Textarea::make('intro')
                            ->label('Introducción')
                            ->rows(4)
                            ->helperText('Texto breve que aparecerá destacado en la página de perfil.')
                            ->columnSpanFull(),

                        FileUpload::make('photo')
                            ->label('Foto principal')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '4:5',
                                '1:1',
                            ])
                            ->imageCropAspectRatio('4:5')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeTargetHeight(1500)
                            ->maxSize(5120),

                        FileUpload::make('secondary_photo')
                            ->label('Foto secundaria')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:5',
                            ])
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1280)
                            ->imageResizeTargetHeight(720)
                            ->maxSize(5120),
                    ])
                    ->columns(2),

                Section::make('Biografía')
                    ->schema([
                        RichEditor::make('biography')
                            ->label('Biografía')
                            ->columnSpanFull(),
                    ]),

                Section::make('Frase destacada')
                    ->schema([
                        Textarea::make('quote')
                            ->label('Frase')
                            ->rows(3)
                            ->helperText('Una frase que pueda utilizarse como elemento visual destacado en el perfil.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Publicación')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Perfil activo')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Cargo')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
