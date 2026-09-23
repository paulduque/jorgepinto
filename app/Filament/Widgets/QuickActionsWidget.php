<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class QuickActionsWidget extends Widget
{
    use HasWidgetShield;

    protected static string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 14;

    protected int|string|array $columnSpan = 'full';

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

        return $user->can('widget_QuickActionsWidget');
    }
}
