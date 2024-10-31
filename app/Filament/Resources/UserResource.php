<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\Action;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Account Management';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                ->default('ARTIST')
                ->options(
                    User::ROLES
                )

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('password')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ADMIN' => 'danger',
                        'EDITOR' => 'info',
                        'ARTIST' => 'success',}),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                    BooleanColumn::make('is_verified')->label('Verified'),
            ])
            ->filters([
                TernaryFilter::make('is_verified')
                ->label('Belum Diverifikasi')
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('verify')
                ->color('success')
                ->label('Verifikasi')
                ->action(function (User $record) {
                    $record->update(['is_verified' => true]); // Cek apakah ini berhasil
                    $record->save(); // Tidak perlu save() jika update() berhasil
                    Notification::make()
                        ->title('Pengguna telah diverifikasi.')
                        ->success()
                        
                        ->send();
                })
                ->requiresConfirmation()
                ->visible(fn (User $record) => !$record->is_verified),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()->role, [User::ROLE_ADMIN, User::ROLE_EDITOR]);

    }

    public static function canView($record): bool
    {
        return in_array(auth()->user()->role, [User::ROLE_ADMIN, User::ROLE_EDITOR]);

    }

    
}
