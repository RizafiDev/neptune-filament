<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Revenue;
use Filament\Support\Enums\IconPosition;

class RevenueWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung total revenue dan memformatnya
        $totalRevenue = Revenue::sum('revenue_amount');
        $formattedRevenue = '$' . number_format($totalRevenue, 2); // Format sebagai mata uang

        return [
            Stat::make('Total Revenue', $formattedRevenue)
                ->description('Total Revenue This Month')
                ->descriptionIcon('heroicon-m-currency-dollar', IconPosition::Before)
                ->chart([1, 2, 6, 3, 11, 4, 20]) // Anda bisa menyesuaikan chart sesuai kebutuhan
                ->color('success'),
        ];
    }
}
