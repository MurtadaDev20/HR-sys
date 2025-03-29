<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationLabel = 'الحضور والانصراف';
    protected static ?string $modelLabel = 'سجل الحضور';
    protected static ?string $navigationGroup = 'الموظفين';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('الموظف')->relationship('user', 'name')->required(),
                DatePicker::make('date')->label('التاريخ'),
                TimePicker::make('check_in')->label('دخول'),
                TimePicker::make('check_out')->label('خروج'),
                Select::make('status')->label('الحالة')->options([
                    'present' => 'حاضر',
                    'absent' => 'غائب',
                    'leave' => 'إجازة',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('الموظف'),
                TextColumn::make('date')->label('التاريخ'),
                TextColumn::make('check_in')->label('دخول'),
                TextColumn::make('check_out')->label('خروج'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
