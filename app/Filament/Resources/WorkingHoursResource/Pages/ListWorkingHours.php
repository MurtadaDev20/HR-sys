<?php

namespace App\Filament\Resources\WorkingHoursResource\Pages;

use App\Filament\Resources\WorkingHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkingHours extends ListRecords
{
    protected static string $resource = WorkingHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
