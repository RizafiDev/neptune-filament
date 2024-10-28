<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/*', function () {
    return view('error');
});

Route::post('login', [LoginController::class, 'login']);
Route::group(['middleware' => 'ensure.user.verified'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
