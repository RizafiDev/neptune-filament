<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistResource\Pages;
use App\Models\Artist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;
use App\Models\Release;
use App\Models\Revenue;

class ArtistResource extends Resource
{
    protected static ?string $model = Artist::class;

    protected static ?string $navigationGroup = 'Account Management';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('artist_name')->required()->label("Artist Name"),
                Forms\Components\TextInput::make('legal_name')->required()->label("Legal Name"),
                Forms\Components\FileUpload::make('artist_avatar')->label("Avatar (1:1)")->preserveFilenames(),
                Forms\Components\FileUpload::make('artist_idcard')->required()->preserveFilenames()->label("ID Card"),
                Forms\Components\TextInput::make('email')->required()->label("Email")->email()->default(auth()->user()->email) // Set default email dari sesi pengguna
                ->disabled(fn () => auth()->user()->role === User::ROLE_ARTIST),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label("ID"),
                Tables\Columns\TextColumn::make('created_at')->label("Since"),
                Tables\Columns\TextColumn::make('artist_avatar')
    ->formatStateUsing(fn ($state) => $state 
        ? '<img src="' . url('storage/' . $state) . '" alt="Avatar" style="max-width: 50px; max-height: 50px; object-fit: cover;">'
        : 'No image')
    ->html()
    ->label('Artist Avatar'),
                Tables\Columns\TextColumn::make('artist_name')->label('Artist Name'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('total_releases')
    ->label("Total Releases")
    ->getStateUsing(function ($record) {
        // Hitung total rilis yang memiliki nama artist yang sama
        return Release::where('artist_name', $record->artist_name)->count();
    }),

 Tables\Columns\TextColumn::make('total_royalties')
    ->label("Total Royalties")
    ->getStateUsing(function ($record) {
        // Hitung total revenue yang memiliki nama artist yang sama
        $totalRevenue = Revenue::where('artist_name', $record->artist_name)->sum('revenue_amount');
        return '$' . number_format($totalRevenue, 2);
    }),


                Tables\Columns\TextColumn::make('artist_idcard')
                ->formatStateUsing(fn ($state) => $state 
                    ? '<img src="' . url('storage/' . $state) . '" alt="ID Card" style="max-width: 50px; max-height: 50px; object-fit: cover;">'
                    : 'No image')
                ->html()
                ->label('ID Card'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListArtists::route('/'),
            'create' => Pages\CreateArtist::route('/create'),
            'edit' => Pages\EditArtist::route('/{record}/edit'),
        ];
    }
}
