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
use App\Filament\Widgets\RevenueWidget;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use App\Models\Artist;

class RevenueResource extends Resource
{
    protected static ?string $model = Revenue::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';


     // Method untuk mendapatkan widget
     public static function getWidgets(): array
    {
        return [
            RevenueWidget::class, // Pastikan ini menggunakan kelas yang tepat
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
             Forms\Components\Select::make('artist_name')
                ->label('Artist')
                ->options(Artist::pluck('artist_name', 'artist_name')->toArray())
                ->searchable()
                ->required(),

            TextInput::make('revenue_amount')
                ->label('Amount ($)')
                ->numeric()
                ->required(),

            TextInput::make('revenue_month')
                ->label('Revenue Month')
                ->type('month') // Menggunakan input type month
                ->required(),
                Forms\Components\FileUpload::make('tf_img_file_path')->label('Pay Document')->preserveFilenames(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            BadgeColumn::make('status')
            ->getStateUsing(function ($record) {
                return match ($record->status) {
                    'waiting' => 'Waiting',
                    'transferred' => 'Transferred',
                    default => 'Waiting',
                };
            })
            ->colors([
                'warning' => 'Waiting',
                'success' => 'Transferred',
            ]),
            Tables\Columns\TextColumn::make('artist_name')
                ->label('Artist Name'),

            Tables\Columns\TextColumn::make('revenue_amount')
                ->label('Amount ($)')
                ->money('USD', true)
                ->sortable(),

            Tables\Columns\TextColumn::make('revenue_month')
                ->label('Month')
                ->sortable(),
                Tables\Columns\TextColumn::make('tf_img_file_path')
                ->formatStateUsing(fn ($state) => $state 
                  ? '<img src="' . url('storage/' . $state) . '" alt="Pay Document" style="max-width: 50px; max-height: 50px; object-fit: cover;">'
                  : 'No image')
               ->html()
             ->label('Pay Document'),
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
            Action::make('transferred') // Mengganti "transfered" menjadi "transferred"
                ->label('Transferred')
                ->action(function ($record) {
                    $record->update(['status' => 'transferred']);
                })
                ->requiresConfirmation()
                ->color('success')
                ->visible(fn ($record) => $record->status !== 'transferred'),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
