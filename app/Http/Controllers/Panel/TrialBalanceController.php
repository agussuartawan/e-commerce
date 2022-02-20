<?php

namespace App\Http\Controllers\Panel;

use App\Models\Account;
use App\Models\TrialBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrialBalanceController extends Controller
{
    public function firstCreate()
    {
        if(TrialBalance::exists()){
            abort(403);
        }
        return view('panel.trial-balance.create');
    }

    public function getForm()
    {
        if(TrialBalance::exists()){
            return 'Saldo awal sudah diatur';
        }
        $accounts = Account::orderBy('account_number', 'ASC')->get();
        return view('include.trial-balance.form', compact('accounts'));
    }

    public function firstStore(Request $request)
    {
        $trial_balance = \DB::transaction(function () use($request) {
            $trial_balance = TrialBalance::create(['date' => $request->date]);
            foreach($request->account_id as $key => $account_id){
                $trial_balance->account()->attach($account_id, [
                    'debit' => $request->debit[$key], 'credit' => $request->credit[$key]
                ]);
            }

            return $trial_balance;
        });

        return redirect()->route('accounts.index')->with('success', 'Neraca saldo awal telah diatur');
    }
}
