<?php

namespace App\Filament\Widgets;

use App\Models\SiteSetting;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 10;

    /**
     * Solo mostrar a usuarios con rol colaborador.
     */
    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        if (! $user) {
            return false;
        }

        $user = \App\Models\User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->hasRole('colaborador');
    }

    protected function getViewData(): array
    {
        return [
            'settings' => SiteSetting::current(),
            'user' => Filament::auth()->user(),
        ];
    }
}
