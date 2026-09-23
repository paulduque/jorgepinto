<?php

namespace App\Filament\Pages;

use App\Models\Event;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Calendario';

    protected static ?string $title = 'Calendario de Campaña';

    protected static ?string $navigationGroup = 'Campaña';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.calendar';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\CalendarWidget::class,
        ];
    }

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        if (! $user) {
            return false;
        }

        // Recargar el modelo desde la BD para asegurar que tiene HasRoles
        $user = User::find($user->id);

        if (! $user) {
            return false;
        }

        return $user->can('view_any_event');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);
    }
}
