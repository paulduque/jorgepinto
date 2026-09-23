<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class NewMessagesWidget extends BaseWidget
{
    protected static ?string $heading = 'Mensajes nuevos';

    protected static ?int $sort = 11;

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

        return $user->can('widget_NewMessagesWidget');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()
                    ->where('status', 'nuevo')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->limit(40)
                    ->placeholder('Sin asunto'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(
                        fn(ContactMessage $record): string =>
                        \App\Filament\Resources\ContactMessageResource::getUrl('view', ['record' => $record])
                    ),

                Tables\Actions\Action::make('markAsRead')
                    ->label('Marcar leído')
                    ->icon('heroicon-o-envelope-open')
                    ->color('info')
                    ->action(fn(ContactMessage $record) => $record->markAsRead()),
            ])
            ->paginated(false)
            ->emptyStateHeading('No hay mensajes nuevos')
            ->emptyStateDescription('Todos los mensajes han sido leídos')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
