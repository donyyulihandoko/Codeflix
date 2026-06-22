<?php

namespace App\Filament\Resources\Memberships\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
// use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;

class MembershipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('User ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                TextColumn::make('plan.title')
                    ->label('Plan')
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                    ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            DeleteAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
