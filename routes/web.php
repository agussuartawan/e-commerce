<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\BankController;
use App\Http\Controllers\Beranda\OrderController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Beranda\PaymentController as BerandaPaymentController;
use App\Http\Controllers\Panel\PaymentController as PanelPaymentController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Beranda\DeliveryController;
use App\Http\Controllers\Panel\ProductUnitController;
use App\Http\Controllers\Panel\ProductColorController;
use App\Http\Controllers\Panel\ProductFragranceController;
use App\Http\Controllers\Panel\SaleController;
use App\Http\Controllers\Panel\UserController;

Route::get('/', function () {
	return redirect()->route('beranda');
});

Route::get('/panel', function () {
	return redirect('/panel/login');
});

Auth::routes();
Route::get('beranda', [BerandaController::class, 'beranda'])->name('beranda');
Route::get('product/{product}/show', [BerandaController::class, 'productShow'])->name('product.show');


Route::group(['middleware' => 'auth'], function () {
	Route::group(['middleware' => 'can:akses dashboard'], function () {
		Route::get('dashboard', DashboardController::class)->name('dashboard');
	});

	Route::group(['middleware' => 'can:akses kategori'], function () {
		Route::resource('categories', CategoryController::class)->except('destroy', 'show');
		Route::get('categories/get-list', [CategoryController::class, 'getCategoryLists']);
	});
	Route::get('categories-search', [CategoryController::class, 'searchCategories']);

	Route::get('color-search', [ProductColorController::class, 'searchColor']);
	Route::get('product-search', [ProductController::class, 'searchProduct']);
	Route::get('fragrance-search', [ProductFragranceController::class, 'searchFragrance']);
	Route::get('unit-search', [ProductUnitController::class, 'searchUnit']);
	Route::group(['middleware' => 'can:akses barang'], function () {
		Route::get('products/get-list', [ProductController::class, 'getProductLists']);
		Route::resource('products', ProductController::class)->except('destroy');
		
		#product color route
		Route::get('color-create', [ProductColorController::class, 'create']);
		Route::post('color-create', [ProductColorController::class, 'store'])->name('color.store');
		
		#product fragrance route
		Route::get('fragrance-create', [ProductFragranceController::class, 'create'])->name('fragrance.create');
		Route::post('fragrance-create', [ProductFragranceController::class, 'store'])->name('fragrance.store');
		
		
		#product unit route
		Route::get('unit-create', [ProductUnitController::class, 'create'])->name('unit.create');
		Route::post('unit-create', [ProductUnitController::class, 'store'])->name('unit.store');
	});

	# customer route
	Route::get('customer-search', [CustomerController::class, 'searchCustomer']);
	Route::group(['middleware' => 'can:akses pelanggan'], function () {
		Route::get('customers/get-list', [CustomerController::class, 'getCustomerLists']);
		Route::resource('customers', CustomerController::class)->except('destroy', 'show');
	});

	# bank route
	Route::group(['middleware' => 'can:akses bank'], function () {
		Route::get('banks/get-list', [BankController::class, 'getBankLists']);
		Route::resource('banks', BankController::class)->except('destroy', 'show');
	});

	# route pemesanan
	Route::group(['middleware' => 'can:akses beranda'], function () {
		Route::get('order/{product}/create', [OrderController::class, 'create'])->name('order.create');
		Route::post('order/{product}/create', [OrderController::class, 'store'])->name('order.store');
		Route::get('order/{sale}/result', [OrderController::class, 'result'])->name('order.result');
		Route::get('order/{sale}/show', [OrderController::class, 'show'])->name('order.show');


		Route::get('payment/{sale}/create', [BerandaPaymentController::class, 'create'])->name('payment.create');
		Route::get('payment', [BerandaPaymentController::class, 'index'])->name('payment.index');
		Route::post('payment/{sale}', [BerandaPaymentController::class, 'store'])->name('payment.store');

		Route::get('delivery', [DeliveryController::class, 'index'])->name('delivery.index');
		Route::put('delivery/{sale}/received', [DeliveryController::class, 'deliveryReceived'])->name('delivery.received');

	});
	Route::get('province-search', [OrderController::class, 'searchProvince']);
	Route::get('city-search/{province_id}', [OrderController::class, 'searchCity']);
	Route::get('bank-search', [BankController::class, 'searchBank']);

	// route data penjualan admin
	Route::group(['middleware' => 'can:akses penjualan'], function () {
		Route::put('sale/{sale}/confirm', [SaleController::class, 'deliveryConfirm']);
		Route::get('sale/get-list', [SaleController::class, 'getSaleList']);
		Route::get('sale/{product}/{sale}/get-variant-list', [SaleController::class, 'getVariantList']);
		Route::resource('sales', SaleController::class)->except('destroy', 'create', 'store');
	});

	// route data pembayaran admin
	Route::group(['middleware' => 'can:akses pembayaran'], function () {
		Route::get('payment/get-list', [PanelPaymentController::class, 'getPaymentList']);
		Route::put('payment/{sale}/confirm', [PanelPaymentController::class, 'paymentConfirm']);
		Route::put('payment/{payment}/cancle', [PanelPaymentController::class, 'paymentCancle'])->name('payment.cancle');
		Route::resource('payments', PanelPaymentController::class)->except('destroy', 'create', 'store');
	});

	// route data user
	Route::get('roles-search', [UserController::class, 'searchRoles']);
	Route::group(['middleware' => 'can:akses user'], function () {
		Route::get('user/get-list', [UserController::class, 'getUserList']);
		Route::resource('users', UserController::class)->except('destroy');
	});
});
