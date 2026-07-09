<?php

namespace App\Filament\Resources\Movies\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\Str;

class MovieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Movie Details')
                        ->icon('heroicon-o-film')
                        ->label('Movie Details')
                        ->description('Enter the details of the movie.')
                        ->columns(2)
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->dehydrated()
                                ->disabled(),
                            Select::make('categories')
                                ->relationship('categories', 'title')
                                ->multiple()
                                ->preload()
                                ->required(),
                            TextInput::make('director')
                                ->required(),
                            TextInput::make('writers')
                                ->required(),
                            TextInput::make('stars')
                                ->required(),
                            Textarea::make('description')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    Step::make('Media & Release')
                        ->label('Media & Release')
                        ->description('Upload media and release date.')
                        ->icon('heroicon-o-video-camera')
                        ->columns(2)
                        ->schema([
                            DateTimePicker::make('release_date')
                                ->required(),
                            TextInput::make('duration')
                                ->required()
                                ->numeric(),
                            FileUpload::make('poster')
                                ->image()
                                ->required(),
                        ]),
                    Step::make('Link Streaming')
                        ->label('Link Streaming')
                        ->description('Enter the streaming links')
                        ->icon('heroicon-o-link')
                        ->schema([
                            TextInput::make('url_720')
                                ->required(),
                            TextInput::make('url_1080')
                                ->required(),
                            TextInput::make('url_4k')
                                ->required(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
