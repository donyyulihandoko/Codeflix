<?php

namespace App\Filament\Resources\Movies\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class MovieInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Movie Details')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('title'),
                                TextEntry::make('slug'),
                                TextEntry::make('categories.title')
                                    ->label('Categories')
                                    ->placeholder('-'),
                                TextEntry::make('director'),
                                TextEntry::make('writers'),
                                TextEntry::make('stars'),
                                TextEntry::make('duration')
                                    ->numeric(),
                                TextEntry::make('description')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Media & Date')
                            ->columns(2)
                            ->schema([
                                ImageEntry::make('poster')
                                    ->columnSpanFull()
                                    ->placeholder('-'),
                                TextEntry::make('release_date')
                                    ->dateTime(),
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                        Tab::make('Link Streaming')
                            ->schema([
                                TextEntry::make('url_720'),
                                TextEntry::make('url_1080'),
                                TextEntry::make('url_4k'),
                            ]),
                ]),
            ]);
    }
}
