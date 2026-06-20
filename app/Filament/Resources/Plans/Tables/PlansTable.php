<?php

namespace App\Filament\Resources\Plans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            // Plan Name Column with ID in description
            TextColumn::make('title')
                ->label('Plan Name')
                ->searchable()
                ->sortable()
                ->weight('bold')
                ->description(fn($record) => "ID Paket: #{$record->id}"),

            // Price Column with currency formatting
            TextColumn::make('price')
                ->label('Price')
                ->money('IDR', locale: 'id')
                ->sortable()
                ->alignEnd()
                ->color('success'),

            // Duration Column with suffix
            TextColumn::make('duration')
                ->label('Duration')
                ->suffix(' Days')
                ->sortable()
                ->alignCenter(),

            // Resolution Column with badge and color coding
            TextColumn::make('resolution')
                ->label('Resolution')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    '4k' => 'danger',
                    '1080p' => 'warning',
                    '720p' => 'info',
                    default => 'gray',
                })
                ->formatStateUsing(fn(string $state): string => strtoupper($state))
                ->alignCenter(),

            // Max Devices Column with icon
            TextColumn::make('max_devices')
                ->label('Max Devices')
                ->icon('heroicon-m-device-phone-mobile')
                ->iconColor('gray')
                ->sortable()
                ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
