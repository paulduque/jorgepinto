<?php

namespace App\Filament\Widgets;

use App\Models\SiteSetting;
use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 10;

    /**
     * Solo mostrar a usuarios que NO tienen acceso a la agenda.
     */
    public static function canView(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();

        if (! $user) {
            return false;
        }

        $user = \App\Models\User::find($user->id);

        if (! $user) {
            return false;
        }

        // Ocultar si tiene acceso a la agenda
        return ! $user->hasAnyRole(['super_admin', 'coordinador']);
    }

    protected function getViewData(): array
    {
        return [
            'settings' => SiteSetting::current(),
            'user' => \Filament\Facades\Filament::auth()->user(),
        ];
    }
}
