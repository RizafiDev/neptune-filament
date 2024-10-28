<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Revenue;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue Stats Overview';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        // Ambil data revenue per bulan dengan format YYYY-MM, lalu ekstrak bulannya
        $revenues = Revenue::selectRaw('SUM(revenue_amount) as total, SUBSTRING(revenue_month, 6, 2) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Membuat array label dan data sesuai dengan bulan
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = array_fill(0, 12, 0); // Inisialisasi data 12 bulan dengan nilai 0

        // Update data berdasarkan hasil dari query
        foreach ($revenues as $revenue) {
            $monthIndex = (int)$revenue->month - 1; // Pastikan indeks array sesuai dengan bulan (0-11)
            $data[$monthIndex] = $revenue->total;   // Memasukkan total revenue per bulan
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue Stats Overview',
                    'data' => $data, // Array total revenue per bulan
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Warna border
                    'borderWidth' => 1, // Ketebalan border
                ],
            ],
            'labels' => $labels, // Label bulan
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa juga diganti dengan 'bar', 'pie', dll.
    }
}
