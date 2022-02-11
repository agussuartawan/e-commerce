<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Panel\LoginController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CategoryController;
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

	Route::group(['middleware' => 'can:akses kategori'], function () {
		Route::resource('categories', CategoryController::class)->except('destroy', 'show');
		Route::get('categories/get-list', [CategoryController::class, 'getCategoryLists']);
	});

});
