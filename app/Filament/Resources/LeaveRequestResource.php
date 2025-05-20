<?php

namespace App\Filament\Resources;


use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\LeaveRequestResource\Widgets\LeaveChart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'طلبات الإجازة';
    protected static ?string $modelLabel = 'طلب إجازة';
    protected static ?string $navigationGroup = 'الموظفين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('الموظف')->relationship('user', 'name')->required(),
                Select::make('leave_type_id')->label('نوع الإجازة')->relationship('leaveType', 'name')->required(),
                DatePicker::make('start_date')->label('من تاريخ')->required(),
                DatePicker::make('end_date')->label('إلى تاريخ')->required(),
                Select::make('status')->label('الحالة')->options([
                    'pending' => 'قيد الانتظار',
                    'approved' => 'موافق عليه',
                    'rejected' => 'مرفوض',
                ]),
                Select::make('approved_by')
                ->label('الموافقة من قبل')
                ->relationship('approvedBy', 'name'),
                Textarea::make('manager_note')->label('ملاحظة المدير')->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('الموظف'),
                TextColumn::make('leaveType.name')->label('نوع الإجازة'),
                TextColumn::make('start_date')->label('من تاريخ'),
                TextColumn::make('end_date')->label('إلى تاريخ'),
                TextColumn::make('status')->label('الحالة'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // public static function getWidgets(): array
    // {
    //     return [
    //         LeaveChart::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
