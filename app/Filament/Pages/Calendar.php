<?php

namespace App\Filament\Pages;

use App\Models\Event;
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
}
