<?php

namespace App\Filament\Pages\Auth;

use App\Models\SiteSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre completo')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    ->required()
                    ->minLength(8)
                    ->same('passwordConfirmation'),
                TextInput::make('passwordConfirmation')
                    ->label('Confirmar contraseña')
                    ->password()
                    ->revealable()
                    ->required()
                    ->dehydrated(false),
            ]);
    }

    public static function canAccess(): bool
    {
        // Solo permitir acceso si el registro está activado en SiteSetting
        return SiteSetting::current()?->registration_enabled ?? false;
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        // 1. Crear el usuario (usando el método padre)
        $user = parent::handleRegistration($data);

        // 2. Asignar el rol por defecto desde SiteSetting
        $settings = SiteSetting::current();
        if ($settings?->default_role) {
            $user->assignRole($settings->default_role);
        }

        return $user;
    }
}
