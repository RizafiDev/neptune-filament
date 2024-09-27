<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RevenueResource\Pages;
use App\Models\Revenue;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RevenueResource extends Resource
{
    protected static ?string $model = Revenue::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('artist_name')
                    ->label('Artist')
                    ->required()
                    ->maxLength(255),

                TextInput::make('revenue_amount')
                    ->label('Amount ($)')
                    ->numeric()
                    ->required(),
                TextInput::make('revenue_month')
                    ->label('Revenue Month')
                    ->type('month') // Set type to 'month'
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artist_name')
                    ->label('Artist Name'),

                Tables\Columns\TextColumn::make('revenue_amount')
                    ->label('Amount ($)')
                    ->money('USD', true) // Format mata uang USD
                    ->sortable(),
                    Tables\Columns\TextColumn::make('revenue_month')
                    ->label('Month')
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
            'index' => Pages\ListRevenues::route('/'),
            'create' => Pages\CreateRevenue::route('/create'),
            'edit' => Pages\EditRevenue::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return in_array(auth()->user()->role, [User::ROLE_ADMIN, User::ROLE_EDITOR]);

    }

}
