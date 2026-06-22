<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Details')
                ->icon('heroicon-o-tag')
                ->description('Details of the category.')
                ->columnSpanFull()
                ->columns([
                    'sm' => 1,
                    'lg' => 2,
                ])
                    ->schema([
                        TextEntry::make('title')
                            ->icon(Heroicon::Tag)
                            ->weight('bold')
                            ->color('primary')
                            ->label('Category Name'),

                        TextEntry::make('slug')
                            ->icon(Heroicon::Bookmark)
                            ->weight('bold')
                            ->color('danger'),

                        TextEntry::make('created_at')
                            ->dateTime()
                            ->icon(Heroicon::Clock)
                            ->weight('bold')
                            ->color('success')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->icon(Heroicon::Clock)
                            ->weight('bold')
                            ->color('success')
                            ->placeholder('-'),
                            ])
            ]);
    }
}
