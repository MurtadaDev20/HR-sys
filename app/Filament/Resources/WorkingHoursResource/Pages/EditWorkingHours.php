<?php

namespace App\Filament\Resources\WorkingHoursResource\Pages;

use App\Filament\Resources\WorkingHoursResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkingHours extends EditRecord
{
    protected static string $resource = WorkingHoursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
