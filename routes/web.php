<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/*', function () {
    return view('error');
});

// routes/web.php
Route::get('/unverified', function () {
    return view('unverified'); // Sesuaikan dengan tampilan yang Anda buat
})->name('unverified');


// routes/web.php
// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



// Route::post('login', [LoginController::class, 'login']);
// Route::group(['middleware' => 'ensure.user.verified'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index']);
// });
