<?php

namespace App\Filament\Resources\Movies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;


class MoviesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('poster')
                    ->label('Poster')
                    ->circular()
                    ->height(50)
                    ->width(50)
                    ->stacked(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('categories.title')
                    ->label('Categories')
                    ->searchable()
                    ->colors(['warning'])
                    ->limitList(
                        limit: 2,
                    ),
                TextColumn::make('release_date')
                    ->sortable()
                    ->date('d M Y'),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->relationship('categories', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Filter Kategori'),
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
