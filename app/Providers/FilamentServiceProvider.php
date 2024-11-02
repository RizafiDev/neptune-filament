<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{

public function boot()
{
    Filament::serving(function () {
        Filament::registerMiddleware([
            'verified', // Menambahkan middleware verifikasi
        ]); 
    });
}
}