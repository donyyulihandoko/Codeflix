<?php

namespace App\Filament\Resources\Crews;

use App\Filament\Resources\Crews\Pages\CreateCrew;
use App\Filament\Resources\Crews\Pages\EditCrew;
use App\Filament\Resources\Crews\Pages\ListCrews;
use App\Filament\Resources\Crews\Pages\ViewCrew;
use App\Filament\Resources\Crews\Schemas\CrewForm;
use App\Filament\Resources\Crews\Schemas\CrewInfolist;
use App\Filament\Resources\Crews\Tables\CrewsTable;
use App\Models\Crew;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CrewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CrewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCrews::route('/'),
            'create' => CreateCrew::route('/create'),
            'view' => ViewCrew::route('/{record}'),
            'edit' => EditCrew::route('/{record}/edit'),
        ];
    }
}
