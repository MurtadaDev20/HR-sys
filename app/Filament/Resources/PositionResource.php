<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'المناصب الوظيفية';
    protected static ?string $modelLabel = 'المنصب';
    protected static ?string $navigationGroup = 'الإعدادات';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->label('المسمى الوظيفي')
                ->required()
                ->extraAttributes(['dir' => 'rtl']),
                TextInput::make('description')
                    ->label('الوصف')
                    ->nullable()
                    ->extraAttributes(['dir' => 'rtl']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('المسمى الوظيفي'),
                TextColumn::make('description')->label('الوصف'),
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
