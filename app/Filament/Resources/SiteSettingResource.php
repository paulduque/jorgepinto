<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información general')
                    ->description('Información principal del sitio web.')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nombre del sitio')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('person_name')
                            ->label('Nombre de Jorge Pinto')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('site_description')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),

                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('site')
                            ->disk('public')
                            ->imageEditor(),

                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('settings/favicon')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(512)
                            ->imageResizeTargetHeight(512)
                            ->maxSize(10240),
                    ])
                    ->columns(2),

                Section::make('Información de contacto')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel(),

                        TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(255),

                        Textarea::make('contact_description')
                            ->label('Descripción de contacto')
                            ->rows(4)
                            ->helperText('Texto que aparecerá en la página de contacto.')
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->email(),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel(),
                    ])
                    ->columns(3),

                Section::make('Redes sociales')
                    ->schema([
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url(),

                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url(),

                        TextInput::make('twitter')
                            ->label('X / Twitter')
                            ->url(),

                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url(),

                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')
                    ->label('Sitio')
                    ->searchable(),

                Tables\Columns\TextColumn::make('person_name')
                    ->label('Persona')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
