<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Panel\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return redirect()->route('beranda');
});

Route::get('/panel', function () {
	return redirect('/panel/login');
});

Auth::routes();

Route::get('panel/login', LoginController::class)->middleware('guest')->name('panel.login');

Route::get('beranda', [BerandaController::class, 'beranda'])->name('beranda');
Route::get('product/{product}/show', [BerandaController::class, 'porductShow'])->name('product.show');


Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'can:akses dashboard'], function () {
		Route::get('dashboard', DashboardController::class)->name('dashboard');
	});
});
