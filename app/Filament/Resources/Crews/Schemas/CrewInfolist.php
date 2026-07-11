<?php

namespace App\Filament\Resources\Crews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;

class CrewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Crew Information')
                    // ->label('Crew Information')
                    ->description('Details of the crew member.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->icon('heroicon-o-user')
                    ->schema([
                        ImageEntry::make('photo')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('name'),
                        TextEntry::make('slug'),
                        TextEntry::make('birth_date')
                            ->date()
                            ->placeholder('-'),
                        TextEntry::make('place_of_birth')
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('biography')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);

    }
}
