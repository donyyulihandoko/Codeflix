<?php

namespace App\Filament\Resources\Crews\Pages;

use App\Filament\Resources\Crews\CrewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCrew extends ViewRecord
{
    protected static string $resource = CrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
