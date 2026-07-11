<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class PlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make('Plan Details')
                ->icon(Heroicon::Film)
                ->description('Details of the subscription plan.')
                ->columnSpanFull()
                ->columns([
                    'sm' => 1,
                    'lg' => 2,
                ])
                ->schema([
                    TextEntry::make('title'),
                    TextEntry::make('price')
                        ->formatStateUsing(fn($state) => number_format($state, 2))
                        ->prefix('Rp '),
                    TextEntry::make('duration'),
                    TextEntry::make('resolution')
                        ->formatStateUsing(fn($state) => strtoupper($state)),
                    TextEntry::make('max_devices')
                    ->formatStateUsing(fn($state) => $state === -1 ? 'Unlimited' : $state)
                        ->placeholder('-'),
                ]),
            ]);
    }
}
