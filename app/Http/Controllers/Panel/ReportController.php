<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Account;
use App\Models\TrialBalance;
use Illuminate\Http\Request;
use App\Models\GeneralJournal;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function sales()
    {
        return view('panel.report.sale.index');
    }

    public function getSaleLists(Request $request)
    {
        $from = explode(" / ", $request->search)[0];
        $to = explode(" / ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
        $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');

        $sales = Sale::with('customer', 'product')->whereBetween('date', $date)->get();

        return view('include.report.sale.list', compact('sales'));
    }

    public function journals()
    {
        return view('panel.report.journal.index');
    }

    public function getJournalLists(Request $request)
    {
        $from = explode(" / ", $request->search)[0];
        $to = explode(" / ", $request->search)[1];

        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $journals = GeneralJournal::with('account')->whereBetween('date', $date)->get();
        $creditSum = rupiah($journals->sum('credit'));
        $debitSum = rupiah($journals->sum('debit'));

        return view('include.report.journal.list', compact('journals', 'creditSum', 'debitSum'));
    }

    public function bigBooks()
    {
        return view('panel.report.big-book.index');
    }

    public function getBigBookLists(Request $request)
    {
        $from = explode(" / ", $request->search)[0];
        $to = explode(" / ", $request->search)[1];
        $date['from'] = Carbon::parse($from)->format('Y-m-d');
        $date['to'] = Carbon::parse($to)->format('Y-m-d');

        $accounts = Account::with('general_journal')->orderBy('account_number', 'ASC')->get();

        return view('include.report.big-book.list', compact('accounts', 'date'));
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

        return;
    }
}
