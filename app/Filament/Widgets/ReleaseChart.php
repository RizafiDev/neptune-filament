<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Release;

class ReleaseChart extends ChartWidget
{
    protected static ?string $heading = 'Releases Per Month';

    protected function getData(): array
    {
        // Ambil data jumlah rilis per bulan berdasarkan created_at
        $releases = Release::selectRaw('COUNT(id) as total, MONTH(created_at) as month, YEAR(created_at) as year')
            ->groupBy('month', 'year')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Membuat array label bulan dan inisialisasi data
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = array_fill(0, 12, 0); // Inisialisasi array dengan nilai 0 untuk 12 bulan

        // Update data berdasarkan hasil dari query
        foreach ($releases as $release) {
            $monthIndex = (int)$release->month - 1; // Sesuaikan indeks array agar sesuai dengan bulan (0-11)
            $data[$monthIndex] += $release->total;   // Tambahkan total rilis ke bulan yang sesuai
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Releases',
                    'data' => $data, // Total rilis per bulan
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Warna latar belakang chart
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Warna border chart
                    'borderWidth' => 1, // Ketebalan border chart
                ],
            ],
            'labels' => $labels, // Label bulan
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe chart 'bar', bisa diganti dengan 'line', 'pie', dll.
    }
}
