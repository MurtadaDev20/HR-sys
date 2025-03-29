<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserCountByRoleChart;
use App\Filament\Widgets\TestWidget;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 0;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الموظفين';
    protected static ?string $modelLabel = 'الموظف';
    protected static ?string $navigationGroup = 'الموظفين';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('الاسم الكامل')->required()->extraAttributes(['dir' => 'rtl']),
                TextInput::make('email')->label('البريد الإلكتروني')->required()->email()->unique(ignoreRecord: true),
                TextInput::make('phone')->label('رقم الهاتف')->nullable()->extraAttributes(['dir' => 'rtl']),
                DatePicker::make('hire_date')->label('تاريخ التوظيف'),
                Select::make('department_id')->label('القسم')->relationship('department', 'name')->nullable(),
                Select::make('position_id')->label('المنصب')->relationship('position', 'title')->nullable(),
                Select::make('manager_id')->label('المدير المباشر')->relationship('manager', 'name')->nullable(),
                TextInput::make('basic_salary')->label('الراتب الأساسي')->numeric(),
                Select::make('role')->label('الدور')->options([
                    'admin' => 'مدير نظام',
                    'hr' => 'الموارد البشرية',
                    'manager' => 'مدير قسم',
                    'employee' => 'موظف عادي',
                ])->default('employee'),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم'),
                TextColumn::make('email')->label('البريد الإلكتروني'),
                TextColumn::make('department.name')->label('القسم'),
                TextColumn::make('position.title')->label('المنصب'),
                TextColumn::make('basic_salary')->label('الراتب الأساسي'),
                TextColumn::make('role')->label('الدور'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // public static function getWidgets(): array
    // {
    //     return [
    //         TestWidget::getStats(),
    //     ];
    // }
}
