<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('panel.dashboard.index', [
            'new_payment' => $this->getNewPaymentCount(),
            'new_order' => $this->getNewOrderCount(),
            'product' => $this->getProductCount(),
            'user' => $this->getNewUserCount(),
        ]);
    }

    public function getNewOrderCount()
    {
        return Sale::where('delivery_status_id', DeliveryStatus::MENUNGGU)->count();
    }

    public function getNewPaymentCount()
    {
        return Sale::where('payment_status_id', PaymentStatus::MENUNGGU_KONFIRMASI)->count();
    }

    public function getProductCount()
    {
        return Product::count();
    }

    public function getNewUserCount()
    {
        return User::whereDate('created_at', Carbon::today())->count();
    }
}
