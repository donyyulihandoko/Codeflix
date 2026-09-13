<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class SubscriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Membership Details')
                ->description('Detailed information about the membership.')
                ->columnSpanFull()
                ->columns([
                    'sm' => 1,
                    'lg' => 2,
                ])
                ->schema([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('plan.title')
                    ->label('Plan'),
                IconEntry::make('active')
                    ->boolean()
                    ->label('Active')
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),
                TextEntry::make('start_date')
                    ->dateTime()
                    ->label('Start Date')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('end_date')
                    ->dateTime()
                    ->label('End Date')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Created At')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->label('Updated At')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                ])
            ]);

    }
}
