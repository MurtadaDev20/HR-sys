<?php

namespace App\Filament\Resources\PayrollAdjustmentResource\Pages;

use App\Filament\Resources\PayrollAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayrollAdjustments extends ListRecords
{
    protected static string $resource = PayrollAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
