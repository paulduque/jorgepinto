<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class LatestNewsWidget extends BaseWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Últimas noticias';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';


    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()->latest('published_at')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->limit(40),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoría')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publicada')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn(News $record): string => NewsResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
