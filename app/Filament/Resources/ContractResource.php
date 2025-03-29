<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'عقود العمل';
    protected static ?string $modelLabel = 'العقد';
    protected static ?string $navigationGroup = 'الرواتب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->label('الموظف')
                ->relationship('user', 'name')
                ->required()
                ->extraAttributes(['dir' => 'rtl']),
            TextInput::make('contract_type')
                ->label('نوع العقد')
                ->required()
                ->extraAttributes(['dir' => 'rtl']),
            DatePicker::make('start_date')->label('تاريخ البداية'),
            DatePicker::make('end_date')->label('تاريخ الانتهاء'),
            Select::make('status')
                ->label('الحالة')
                ->options([
                    'active' => 'ساري',
                    'expired' => 'منتهي',
                ])
                ->required()
                ->extraAttributes(['dir' => 'rtl']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('اسم الموظف'),
                TextColumn::make('contract_type')->label('نوع العقد'),
                TextColumn::make('status')->label('الحالة'),
                TextColumn::make('start_date')->label('تاريخ البداية'),
                TextColumn::make('end_date')->label('تاريخ الانتهاء'),
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
