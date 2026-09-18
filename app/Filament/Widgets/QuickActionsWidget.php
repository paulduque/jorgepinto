<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class QuickActionsWidget extends Widget
{
    use HasWidgetShield;

    protected static string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';
}
