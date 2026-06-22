<?php

namespace App\Filament\Resources\Memberships\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class MembershipInfolist
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
                    ->label('User')
                    ->icon('heroicon-o-user')
                    ->color('primary')
                    ->weight('bold'),
                TextEntry::make('plan.title')
                    ->label('Plan')
                    ->color('primary')
                    ->weight('bold')
                    ->icon('heroicon-o-cube')
                    ->color('secondary'),
                IconEntry::make('active')
                    ->boolean()
                    ->label('Active')
                    ->icon('heroicon-o-check-circle')
                    ->color('success'),
                TextEntry::make('start_date')
                    ->dateTime()
                    ->label('Start Date')
                    ->color('success')
                    ->icon('heroicon-o-calendar')
                    ->weight('bold')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('end_date')
                    ->dateTime()
                    ->label('End Date')
                    ->icon('heroicon-o-calendar')
                    ->color('danger')
                    ->weight('bold')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Created At')
                    ->weight('bold')
                    ->icon('heroicon-o-rectangle-stack')
                    ->color('secondary')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->weight('bold')
                    ->icon('heroicon-o-rectangle-stack')
                    ->color('secondary')
                    ->label('Updated At')
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ? $state->format('F j, Y, g:i A') : '-'),
                ])
            ]);
    }
}
