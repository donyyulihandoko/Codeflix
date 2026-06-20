<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Details')
                    ->description('Enter the details of the subscription plan.')
                    ->icon(Heroicon::Film)
                    ->schema([
                        TextInput::make('title')->label('Title')->required()->maxLength(100)->string(),
                        TextInput::make('price')->label('Price (IDR)')->numeric()->required(),
                        TextInput::make('duration')->label('Duration (days)')->numeric()->required(),
                        Select::make('resolution')
                            ->label('Resolution')
                            ->options([
                                '720p' => '720p',
                                '1080p' => '1080p',
                                '4k' => '4k',
                            ])
                            ->required(),
                        TextInput::make('max_devices')->label('Max Devices')->numeric()->required(),
                    ])->columnSpanFull()
                    ->columns([
                        'sm' => 1,
                        'lg' => 2,
                    ]),
            ]);
}
}
