<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;
    protected static ?string $title = 'إضافة قسم جديد';
    protected static ?string $navigationLabel = 'إضافة قسم';
    protected static ?string $navigationGroup = 'إدارة الأقسام';
    protected static ?string $navigationIcon = 'heroicon-o-plus';
}
