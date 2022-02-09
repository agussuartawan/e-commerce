<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('beranda');
});

Auth::routes();

Route::get('beranda', [BerandaController::class, 'beranda'])->name('beranda');


Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'can:akses dashboard'], function () {
		Route::get('dashboard', DashboardController::class)->name('dashboard');

	});
});
