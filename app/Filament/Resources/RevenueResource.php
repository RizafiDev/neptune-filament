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
use Filament\Tables\Table;

class RevenueResource extends Resource
{
    protected static ?string $model = Revenue::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                ->type('month') // Menggunakan input type month
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('artist_name')
                ->label('Artist Name'),

            Tables\Columns\TextColumn::make('revenue_amount')
                ->label('Amount ($)')
                ->money('USD', true)
                ->sortable(),

            Tables\Columns\TextColumn::make('revenue_month')
                ->label('Month')
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('revenue_month')
                ->label('Filter by Month')
                ->options([
                    '01' => 'January',
                    '02' => 'February',
                    '03' => 'March',
                    '04' => 'April',
                    '05' => 'May',
                    '06' => 'June',
                    '07' => 'July',
                    '08' => 'August',
                    '09' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
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
        return auth()->user() && in_array(auth()->user()->role, [User::ROLE_ADMIN, User::ROLE_EDITOR]);
    }
}
