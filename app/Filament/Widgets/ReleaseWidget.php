<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Release;
use Filament\Support\Enums\IconPosition;

class ReleaseWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Release', Release::count())
            ->description('Total Release' )
            ->descriptionIcon('heroicon-m-shield-exclamation', IconPosition::Before)
            ->chart([1, 2, 5, 3, 20, 4, 1])
            ->color('info'),

            Stat::make('Pending Release', Release::whereIn('status', ['review', 'rejected'])->count())
            ->description('Need your action' )
            ->descriptionIcon('heroicon-m-shield-exclamation', IconPosition::Before)
            ->chart([1, 2, 5, 3, 20, 4, 1])
            ->color('warning'),
            
            Stat::make('Released', Release::where('status', 'approved')->count() )
            ->description('Success Music Released' )
            ->descriptionIcon('heroicon-m-musical-note', IconPosition::Before)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
