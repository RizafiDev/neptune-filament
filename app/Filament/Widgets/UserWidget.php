<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use Filament\Support\Enums\IconPosition;

class UserWidget extends BaseWidget
{

    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count() )
            ->description('Active artist users' )
            ->descriptionIcon('heroicon-m-user', IconPosition::Before)
            ->chart([1, 2, 6, 3, 11, 4, 20])
            ->color('info'),

            Stat::make('Pending Users', User::where('is_verified', false)->count() )
            ->description('Waiting for action' )
            ->descriptionIcon('heroicon-m-shield-exclamation', IconPosition::Before)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning'), 

            Stat::make('Verified User', User::where('is_verified', true)->count() )
            ->description('User accepted' )
            ->descriptionIcon('heroicon-m-check', IconPosition::Before)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
