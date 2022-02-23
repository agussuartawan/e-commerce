<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialBalance extends Model
{
    use HasFactory;

    protected $fillable = ['date'];

    public function account()
    {
        return $this->belongsToMany(Account::class)->withPivot('debit', 'credit');
    }

    public function updateTrialBalance($month, $year)
    {
        $accounts = Account::with('general_journal')->get();
        foreach($accounts as $account){
            $journals = GeneralJournal::where('account_id', $account->id)->whereMonth('date', $month)->whereYear('date', $year)->get();
            if(count($journals) != 0){
                $date['previousMonthStartDate'] = new \Carbon\Carbon('first day of last month');
                $date['previousMonthEndDate'] = new \Carbon\Carbon('last day of last month');

                $previousTrialBalance = $this->whereBetween('date', $date)->first();
                $previousTotalDebit = 0;
                $previousTotalCredit = 0;
                if($previousTrialBalance){
                    if($previousTrialBalance->account->where('account_id', $account->id)->first()){
                        $previousTotalDebit = $previousTrialBalance->account->where('account_id', $account->id)->first()->debit;
                        $previousTotalCredit = $previousTrialBalance->account->where('account_id', $account->id)->first()->credit;
                    }
                }

                $debitSum = $journals->sum('debit') + $previousTotalDebit - $previousTotalCredit;
                $creditSum = $journals->sum('credit') + $previousTotalCredit - $previousTotalDebit;
    
                $this->account()->updateExistingPivot($account->id, [
                    'debit' => $debitSum,
                    'credit' => $creditSum
                ]);
            } else {
                if($this->is_first != 0){
                    $this->account()->attach($account->id, [
                        'debit' => 0,
                        'credit' => 0
                    ]);
                }  
            }
        } 
    }
}
