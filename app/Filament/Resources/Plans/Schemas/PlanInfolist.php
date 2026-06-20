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
                    TextEntry::make('title')->label('Title')->icon(Heroicon::Tag)->weight('bold')->color('primary'),
                    TextEntry::make('price')->label('Price (IDR)')->formatStateUsing(fn($state) => number_format($state, 2))->prefix('Rp ')->icon(Heroicon::CreditCard)->color('success')->weight('bold'),
                    TextEntry::make('duration')->label('Duration (days)')->icon(Heroicon::Clock)->weight('bold')->color('danger'),
                    TextEntry::make('resolution')->weight('bold')->label('Resolution')->color('secondary')->icon(Heroicon::OutlinedComputerDesktop)->formatStateUsing(fn($state) => strtoupper($state)),
                    TextEntry::make('max_devices')->label('Max Devices')->icon(Heroicon::DevicePhoneMobile)->color('secondary')->formatStateUsing(fn($state) => $state === -1 ? 'Unlimited' : $state)->weight('bold'),
                ]),
            ]);
    }
}
