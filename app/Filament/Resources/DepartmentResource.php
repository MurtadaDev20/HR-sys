<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Filament\Resources\DepartmentResource\RelationManagers;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الأقسام';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static ?string $label = 'قسم';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('اسم القسم')
                ->required()
                ->autofocus()
                ->extraAttributes(['dir' => 'rtl']),

            Select::make('parent_id')
                ->label('القسم الرئيسي')
                ->relationship('parent', 'name')
                ->nullable()
                ->extraAttributes(['dir' => 'rtl']),

            Select::make('manager_id')
                ->label('مدير القسم')
                ->relationship('manager', 'name')
                ->nullable()
                ->extraAttributes(['dir' => 'rtl']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('اسم القسم')->searchable()->sortable(),
                TextColumn::make('parent.name')->label('القسم الرئيسي'),
                TextColumn::make('manager.name')->label('مدير القسم'),
                TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime(),
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
