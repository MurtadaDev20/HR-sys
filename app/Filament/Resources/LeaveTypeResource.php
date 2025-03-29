<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveTypeResource\Pages;
use App\Filament\Resources\LeaveTypeResource\RelationManagers;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveTypeResource extends Resource
{
    protected static ?string $model = LeaveType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'أنواع الإجازات';
    protected static ?string $modelLabel = 'نوع الإجازة';
    protected static ?string $navigationGroup = 'الإعدادات';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('اسم الإجازة')->required()->extraAttributes(['dir' => 'rtl']),
            TextInput::make('max_days')->label('الحد الأقصى للأيام')->numeric()->nullable()->extraAttributes(['dir' => 'rtl']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('اسم الإجازة'),
                TextColumn::make('max_days')->label('عدد الأيام')
                    ->sortable()
                    ->searchable()
                    ->extraAttributes(['dir' => 'rtl']),
                TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime(),
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
            'index' => Pages\ListLeaveTypes::route('/'),
            'create' => Pages\CreateLeaveType::route('/create'),
            'edit' => Pages\EditLeaveType::route('/{record}/edit'),
        ];
    }
}
