<?php

namespace App\Filament\Resources\Ratings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RatingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('movie.title')
                    ->label('Movie'),
                TextEntry::make('rating')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
