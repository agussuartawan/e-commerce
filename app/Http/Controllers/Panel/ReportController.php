<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Account;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\TrialBalance;
use Illuminate\Http\Request;
use App\Models\GeneralJournal;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function getBestProduct()
    {
        $products = Product::get();
        $product_selling_count = [];
        foreach ($products as $product) {
            $product_selling_count[] = [
                'qty' => $product->sale()->where('is_cancel', '=', 0)->sum('qty'),
                'id' => $product->id
            ];
        }
        rsort($product_selling_count);
        $bestselling = array_slice($product_selling_count, 0, 5);
        foreach ($bestselling as $key => $value) {
            $best_seller_product_id[] = $value['id'];
        }
        
        return Product::whereIn('id', $best_seller_product_id)->get();
    }

    public function bestSellerChart()
    {
        $best_seller_product = $this->getBestProduct();

        foreach($best_seller_product as $key => $item){
            $chartData['labels'][] = $item->product_name;
            $chartData['data'][] = $item->sale->sum('qty');
        }

        return json_encode($chartData);
    }

    public function sales()
    {
        $best_seller_product = $this->getBestProduct();
        $best_seller_chart = $this->bestSellerChart();
        return view('panel.report.sale.index', compact('best_seller_product', 'best_seller_chart'));
    }

    public function getSaleLists(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');

        $sales = Sale::with('customer', 'product')->whereBetween('date', $date)->where('is_cancel', 0)->get();

        return view('include.report.sale.list', compact('sales'));
    }

    public function salesReportPrint(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');

        $sales = Sale::with('customer', 'product')->whereBetween('date', $date)->where('is_cancel', 0)->get();
        $best_seller_product = $this->getBestProduct();

        $pdf = PDF::loadView('pdf.sales', compact('sales', 'date', 'best_seller_product'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('laporan-penjualan.pdf');
    }

    public function salesReportDownload(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');

        $sales = Sale::with('customer', 'product')->whereBetween('date', $date)->where('is_cancel', 0)->get();
        $best_seller_product = $this->getBestProduct();

        $pdf = PDF::loadView('pdf.sales', compact('sales', 'date', 'best_seller_product'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->download('laporan-penjualan.pdf');
    }

    public function journals()
    {
        return view('panel.report.journal.index');
    }

    public function getJournalLists(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $journals = GeneralJournal::with('account')->whereBetween('date', $date)->get();
        $creditSum = rupiah($journals->sum('credit'));
        $debitSum = rupiah($journals->sum('debit'));

        return view('include.report.journal.list', compact('journals', 'creditSum', 'debitSum'));
    }

    public function journalsReportPrint(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d');

        $journals = GeneralJournal::with('account')->whereBetween('date', $date)->get();

        $pdf = PDF::loadView('pdf.journals', compact('journals', 'date'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('laporan-jurnal-umum.pdf');
    }

    public function journalsReportDownload(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');

        $journals = GeneralJournal::with('account')->whereBetween('date', $date)->get();

        $pdf = PDF::loadView('pdf.journals', compact('journals', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->download('laporan-jurnal-umum.pdf');
    }

    public function bigBooks()
    {
        return view('panel.report.big-book.index');
    }

    public function getBigBookLists(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $accounts = Account::with('general_journal')->orderBy('account_number', 'ASC')->get();

        return view('include.report.big-book.list', compact('accounts', 'date'));
    }

    public function ledgerReportPrint(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $accounts = Account::with('general_journal')->orderBy('account_number', 'ASC')->get();

        $pdf = PDF::loadView('pdf.ledger', compact('accounts', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('laporan-buku-besar.pdf');
    }

    public function ledgerReportDownload(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $accounts = Account::with('general_journal')->orderBy('account_number', 'ASC')->get();

        $pdf = PDF::loadView('pdf.ledger', compact('accounts', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->download('laporan-buku-besar.pdf');
    }

    public function trialBalance()
    {
        $trialBalanceExists = true;
        if(!TrialBalance::exists()){
            $trialBalanceExists = false;
        }

        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11'=> 'November',
            '12' => 'Desember',
        ];

        $now = date('Y');
        for($i = 2020; $i <= $now; $i++){
            $years[$i] = $i;
        }

        return view('panel.report.trial-balance.index', compact('trialBalanceExists', 'months', 'years'));
    }

    public function getTrialBalanceLists(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $trialBalance = TrialBalance::whereMonth('date', $month)->whereYear('date', $year)->first();

        $now = $year . '-' . $month . '-' . date('d');

        if(!$trialBalance && $now == date('Y-m-d')){
            $this->storeTrialBalance($month, $year);
        } elseif($trialBalance) {
            $trialBalance->updateTrialBalance($month, $year);
        }

        $trialBalance = TrialBalance::with('account')->whereMonth('date', $month)->whereYear('date', $year)->first();

        return view('include.report.trial-balance.list', compact('trialBalance'));
    }

    public function storeTrialBalance($month,$year)
    {
        $date['previousMonthStartDate'] = new Carbon('first day of last month');
        $date['previousMonthEndDate'] = new Carbon('last day of last month');

        $date = [
            $date['previousMonthStartDate']->format('Y-m-d'),
            $date['previousMonthEndDate']->format('Y-m-d')
        ];

        $trialBalanceLastMonth = TrialBalance::whereBetween('date', $date)->first();

        if($trialBalanceLastMonth){
            \DB::transaction(function () use($month, $year, $trialBalanceLastMonth){
                $trialBalance = TrialBalance::create(['date' => now(), 'is_first' => 0]);

                $accounts = Account::orderBy('account_number', 'ASC')->get();

                foreach($accounts as $account){
                    $journals = GeneralJournal::where('account_id', $account->id)->whereMonth('date', $month)->whereYear('date', $year)->get();
                    $debitSum = 0;
                    $creditSum = 0;

                    if($journals){
                        if($account->balance_type == 'Debet'){
                            $debitSum = $journals->sum('debit') - $journals->sum('credit');
                            $creditSum = 0;
                        } elseif($account->balance_type == 'Kredit'){
                            $creditSum = $journals->sum('credit') - $journals->sum('debit');
                            $debitSum = 0;
                        }
    
                        if($trialBalanceLastMonth->account()->where('account_id', $account->id)->first()){
                            $previousDebitSum = $trialBalanceLastMonth->account()->where('account_id', $account->id)->first()->pivot->debit;
                            $previousCreditSum = $trialBalanceLastMonth->account()->where('account_id', $account->id)->first()->pivot->credit;
    
                            if($account->balance_type == 'Debet'){
                                $debitSum = $debitSum + $previousDebitSum - $previousCreditSum;
                                $creditSum = 0;
                            } elseif($account->balance_type == 'Kredit'){
                                $creditSum = $creditSum + $previousCreditSum - $previousDebitSum;
                                $debitSum = 0;
                            }
                        }
    
                    }

                    $trialBalance->account()->attach($account->id, [
                        'debit' => $debitSum,
                        'credit' => $creditSum
                    ]);
                }    
            });
        }

        // return;
    }

    public function trialBalanceReportPrint(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $date = $year . '-' . $month . '-' . date('d');

        $trialBalances = TrialBalance::with('account')->whereMonth('date', $month)->whereYear('date', $year)->first();

        $pdf = PDF::loadView('pdf.trial-balance', compact('trialBalances', 'date'));
        $pdf->setPaper('A4', 'potrait');
        
        return $pdf->stream('laporan-neraca-saldo.pdf');
    }

    public function trialBalanceReportDownload(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $date = $year . '-' . $month . '-' . date('d');

        $trialBalances = TrialBalance::with('account')->whereMonth('date', $month)->whereYear('date', $year)->first();

        $pdf = PDF::loadView('pdf.trial-balance', compact('trialBalances', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->download('laporan-neraca-saldo.pdf');
    }

    public function productIncomes()
    {
        return view('panel.report.product-income.index');
    }

    public function getProductIncomeLists(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $avenues = Sale::orderBy('date', 'ASC')->get();
        $incomes = Purchase::orderBy('date', 'ASC')->get();

        $sum_income = 0;
        foreach($incomes as $a){
            $sum_income = $sum_income + (int)$a->product->sum('pivot.qty');
        }

        return view('include.report.product-income.list', compact('avenues', 'incomes', 'sum_income', 'date'));
    }
    public function productIncomeReportPrint(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $sales = Sale::orderBy('date', 'ASC')->get();
        $incomes = Purchase::orderBy('date', 'ASC')->get();
        $sum_income = 0;
        foreach($incomes as $a){
            $sum_income = $sum_income + (int)$a->product->sum('pivot.qty');
        }

        $pdf = PDF::loadView('pdf.product-income', compact('incomes', 'sum_income', 'sales', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('laporan-barang-masuk.pdf');
    }

    public function productIncomeReportDownload(Request $request)
    {
        $from = explode(" s/d ", $request->search)[0];
        $to = explode(" s/d ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $incomes = Purchase::orderBy('date', 'ASC')->get();
        $avenues = Sale::orderBy('date', 'ASC')->get();

        $pdf = PDF::loadView('pdf.product-income', compact('incomes', 'avenues', 'date'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->download('laporan-barang-masuk.pdf');
    }
}
