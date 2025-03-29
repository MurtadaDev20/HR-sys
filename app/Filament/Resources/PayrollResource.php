<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الرواتب';
    protected static ?string $modelLabel = 'الراتب';
    protected static ?string $navigationGroup = 'الرواتب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('الموظف')->relationship('user', 'name')->required(),
                TextInput::make('pay_month')->label('شهر الدفع')->required(),
                TextInput::make('basic_salary')->label('الراتب الأساسي')->numeric(),
                TextInput::make('bonus')->label('المكافآت')->numeric(),
                TextInput::make('deductions')->label('الخصومات')->numeric(),
                TextInput::make('net_salary')->label('الصافي')->numeric(),
                Select::make('payment_status')->label('حالة الدفع')->options([
                    'paid' => 'مدفوع',
                    'pending' => 'قيد الانتظار',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('الموظف'),
                TextColumn::make('pay_month')->label('الشهر'),
                TextColumn::make('net_salary')->label('الصافي'),
                TextColumn::make('payment_status')->label('الحالة'),
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
