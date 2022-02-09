<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('beranda');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('beranda', [BerandaController::class, 'beranda'])->name('beranda');

// Route::group(['prefix' => 'panel'], function () {
Route::get('/dashboard', DashboardController::class)->name('dashboard');
// });
