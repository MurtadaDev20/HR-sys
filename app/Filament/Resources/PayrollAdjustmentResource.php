<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollAdjustmentResource\Pages;
use App\Filament\Resources\PayrollAdjustmentResource\RelationManagers;
use App\Models\PayrollAdjustment;
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

class PayrollAdjustmentResource extends Resource
{
    protected static ?string $model = PayrollAdjustment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الخصومات والمكافآت';
    protected static ?string $modelLabel = 'تعديل على الراتب';
    protected static ?string $navigationGroup = 'الرواتب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('payroll_id')
                    ->label('مسير الراتب')
                    ->relationship('payroll', 'pay_month')
                    ->required()
                    ->extraAttributes(['dir' => 'rtl']),
                Select::make('type')
                    ->label('النوع')
                    ->options([
                        'bonus' => 'مكافأة',
                        'deduction' => 'خصم',
                    ])
                    ->required()
                    ->extraAttributes(['dir' => 'rtl']),
                TextInput::make('label')->label('الوصف')->required()->extraAttributes(['dir' => 'rtl']),
                TextInput::make('amount')->label('المبلغ')->numeric()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payroll.user.name')->label('الموظف'),
                TextColumn::make('payroll.pay_month')->label('الشهر'),
                TextColumn::make('type')->label('النوع'),
                TextColumn::make('label')->label('الوصف'),
                TextColumn::make('amount')->label('المبلغ'),
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
            'index' => Pages\ListPayrollAdjustments::route('/'),
            'create' => Pages\CreatePayrollAdjustment::route('/create'),
            'edit' => Pages\EditPayrollAdjustment::route('/{record}/edit'),
        ];
    }
}
