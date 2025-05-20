<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkingHoursResource\Pages;
use App\Filament\Resources\WorkingHoursResource\RelationManagers;
use App\Models\Working_hour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkingHoursResource extends Resource
{
    protected static ?string $model = Working_hour::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الوقت العملي';
    protected static ?string $modelLabel = 'الوقت العملي';
    protected static ?string $navigationGroup = 'الموظفين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TimePicker::make('check_in')
                    ->label('الدخول')
                    ->required(),
                Forms\Components\TimePicker::make('check_out')
                    ->label('الخروج')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('check_in')
                    ->label('الدخول')
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_out')
                    ->label('الخروج')
                    ->sortable(),
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
            'index' => Pages\ListWorkingHours::route('/'),
            'create' => Pages\CreateWorkingHours::route('/create'),
            'edit' => Pages\EditWorkingHours::route('/{record}/edit'),
        ];
    }
}
