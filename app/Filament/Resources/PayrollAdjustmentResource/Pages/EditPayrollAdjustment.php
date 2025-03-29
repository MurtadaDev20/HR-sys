<?php

namespace App\Filament\Resources\PayrollAdjustmentResource\Pages;

use App\Filament\Resources\PayrollAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayrollAdjustment extends EditRecord
{
    protected static string $resource = PayrollAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
