<?php

namespace App\Filament\Resources\Crews\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class CrewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make('Crew Information')
                ->label('Crew Information')
                ->description('Please fill out the crew information below.')
                ->columns(2)
                ->columnSpanFull()
                ->icon('heroicon-o-user')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->dehydrated()
                        ->disabled(),
                    DatePicker::make('birth_date')
                        ->label('Birth Date')
                        ->required(),
                    TextInput::make('place_of_birth')
                        ->label('Place of Birth')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('biography')
                        ->label('Biography')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                    FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->disk('public') // Menyimpan file ke storage/app/public
                        ->directory('crews/photos') // Menyimpan di subfolder storage/app/public/crews/photos
                        ->visibility('public')
                        ->maxSize(1024) // Maksimal ukuran file dalam kilobytes (1MB)
                        ->required(),

                ]),
            ]);
    }
}
