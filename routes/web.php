<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\Panel\BankController;
use App\Http\Controllers\Panel\SaleController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\ReportController;
use App\Http\Controllers\Beranda\OrderController;
use App\Http\Controllers\Panel\AccountController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Beranda\BerandaController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Beranda\DeliveryController;
use App\Http\Controllers\Panel\ProductUnitController;
use App\Http\Controllers\Panel\ProductColorController;
use App\Http\Controllers\Panel\TrialBalanceController;
use App\Http\Controllers\Panel\GeneralJournalController;
use App\Http\Controllers\Panel\ProductFragranceController;
use App\Http\Controllers\Panel\PaymentController as PanelPaymentController;
use App\Http\Controllers\Beranda\PaymentController as BerandaPaymentController;

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
		Route::resource('categories', CategoryController::class)->except('show');
		Route::get('categories/get-list', [CategoryController::class, 'getCategoryLists']);
	});
	Route::get('categories-search', [CategoryController::class, 'searchCategories']);

	Route::get('color-search', [ProductColorController::class, 'searchColor']);
	Route::get('product-search', [ProductController::class, 'searchProduct']);
	Route::get('fragrance-search', [ProductFragranceController::class, 'searchFragrance']);
	Route::get('unit-search', [ProductUnitController::class, 'searchUnit']);
	Route::group(['middleware' => 'can:akses barang'], function () {
		Route::get('products/get-list', [ProductController::class, 'getProductLists']);
		Route::get('product/manage-image/{product}', [ProductController::class, 'imageForm'])->name('product.image-form');
		Route::post('product/manage-image/{product}', [ProductController::class, 'imageStore'])->name('product.image-store');
		Route::get('product/thumbnail/{product}', [ProductController::class, 'thumbnail'])->name('product.thumbnail');
		Route::delete('product/remove-image/{image}', [ProductController::class, 'removeImage']);
		Route::resource('products', ProductController::class);
		
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
	Route::get('order/{sale}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
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
		Route::get('sale/form-order/{sale}', [SaleController::class, 'formOrder']);
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

	// route data akun
	Route::group(['middleware' => 'can:akses akun'], function () {
		// akun route
		Route::resource('accounts', AccountController::class)->except('show');
		Route::get('account/get-list', [AccountController::class, 'getAccountList']);
		Route::get('account-search', [AccountController::class, 'searchAccount']);
		
		//neraca saldo route
		Route::get('trial-balance/get-form', [TrialBalanceController::class, 'getForm']);
		Route::get('trial-balance/first-create', [TrialBalanceController::class, 'firstCreate'])->name('trial-balance.first-create');
		Route::post('trial-balance/first-create', [TrialBalanceController::class, 'firstStore'])->name('trial-balance.first-store');
	});

	// jurnal umum route
	Route::group(['middleware' => 'can:akses jurnal umum'], function () {
		Route::resource('journals', GeneralJournalController::class)->except('destroy', 'show');
		Route::get('journal/get-list', [GeneralJournalController::class, 'getJournalList']);
	});

	// laporan route
	Route::group(['middleware' => 'can:akses laporan'], function () {
		// laporan penjualan
		Route::get('report/sales', [ReportController::class, 'sales'])->name('report.sales');
		Route::get('report/sales/get-lists', [ReportController::class, 'getSaleLists']);
		Route::get('report/sales-download', [ReportController::class, 'salesReportDownload']);
		Route::get('report/sales-print', [ReportController::class, 'salesReportPrint']);

		// laporan jurnal umum
		Route::get('report/journals', [ReportController::class, 'journals'])->name('report.journals');
		Route::get('report/journals/get-lists', [ReportController::class, 'getJournalLists']);
		Route::get('report/journals-download', [ReportController::class, 'journalsReportDownload']);
		Route::get('report/journals-print', [ReportController::class, 'journalsReportPrint']);

		// buku besar route
		Route::get('report/big-books', [ReportController::class, 'bigBooks'])->name('report.bigBooks');
		Route::get('report/big-books/get-lists', [ReportController::class, 'getBigBookLists']);
		Route::get('report/ledger-download', [ReportController::class, 'ledgerReportDownload']);
		Route::get('report/ledger-print', [ReportController::class, 'ledgerReportPrint']);

		// neraca saldo route
		Route::get('report/trial-balances', [ReportController::class, 'trialBalance'])->name('report.trialBalances');
		Route::get('report/trial-balances/get-lists', [ReportController::class, 'getTrialBalanceLists']);
		Route::get('report/trial-balance-download', [ReportController::class, 'trialBalanceReportDownload']);
		Route::get('report/trial-balance-print', [ReportController::class, 'trialBalanceReportPrint']);
	});

	Route::group(['middleware' => 'can:akses wilayah'], function () {
		Route::resource('region/provinces', ProvinceController::class)->except('show');
		Route::resource('region/cities', CityController::class)->except('show');
		Route::get('region', RegionController::class)->name('region.index');
	});
});