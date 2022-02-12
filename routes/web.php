<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Panel\BankController;
use App\Http\Controllers\Panel\LoginController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Panel\ProductUnitController;
use App\Http\Controllers\Panel\ProductColorController;
use App\Http\Controllers\Panel\ProductFragranceController;

Route::get('/', function () {
	return redirect()->route('beranda');
});

Route::get('/panel', function () {
	return redirect('/panel/login');
});

Auth::routes();
Route::get('panel/login', LoginController::class)->middleware('guest')->name('panel.login');
Route::get('beranda', [BerandaController::class, 'beranda'])->name('beranda');
Route::get('product/{product}/show', [BerandaController::class, 'productShow'])->name('product.show');


Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'can:akses dashboard'], function () {
		Route::get('dashboard', DashboardController::class)->name('dashboard');
	});

	Route::group(['middleware' => 'can:akses kategori'], function () {
		Route::resource('categories', CategoryController::class)->except('destroy', 'show');
		Route::get('categories/get-list', [CategoryController::class, 'getCategoryLists']);
		Route::get('categories-search', [CategoryController::class, 'searchCategories']);
	});

	Route::group(['middleware' => 'can:akses barang'], function () {
		Route::get('products/get-list', [ProductController::class, 'getProductLists']);
		Route::resource('products', ProductController::class)->except('destroy');
		
		#product color route
		Route::get('color-search', [ProductColorController::class, 'searchColor']);
		Route::get('color-create', [ProductColorController::class, 'create']);
		Route::post('color-create', [ProductColorController::class, 'store'])->name('color.store');
		
		#product fragrance route
		Route::get('fragrance-search', [ProductFragranceController::class, 'searchFragrance']);
		Route::get('fragrance-create', [ProductFragranceController::class, 'create'])->name('fragrance.create');
		Route::post('fragrance-create', [ProductFragranceController::class, 'store'])->name('fragrance.store');
		
		
		#product unit route
		Route::get('unit-search', [ProductUnitController::class, 'searchUnit']);
		Route::get('unit-create', [ProductUnitController::class, 'create'])->name('unit.create');
		Route::post('unit-create', [ProductUnitController::class, 'store'])->name('unit.store');
	});

	# customer route
	Route::group(['middleware' => 'can:akses pelanggan'], function () {
		Route::get('customers/get-list', [CustomerController::class, 'getCustomerLists']);
		Route::resource('customers', CustomerController::class)->except('destroy', 'show');
	});

	# bank route
	Route::group(['middleware' => 'can:akses bank'], function () {
		Route::get('banks/get-list', [BankController::class, 'getBankLists']);
		Route::resource('banks', BankController::class)->except('destroy', 'show');
	});

});
