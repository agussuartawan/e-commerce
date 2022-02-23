<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialBalance extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'is_first'];

    public function account()
    {
        return $this->belongsToMany(Account::class)->withPivot('debit', 'credit');
    }

    public function updateTrialBalance($month, $year)
    {
        $date['previousMonthStartDate'] = new \Carbon\Carbon('first day of last month');
        $date['previousMonthEndDate'] = new \Carbon\Carbon('last day of last month');

        $previousTrialBalance = $this->whereBetween('date', $date)->first();              

        if($previousTrialBalance){
            $accounts = Account::with('general_journal')->get();
            foreach($accounts as $account){
                $journals = GeneralJournal::where('account_id', $account->id)->whereMonth('date', $month)->whereYear('date', $year)->get();
                if($journals){
                    if($account->balance_type == 'Debet'){
                        $debitSum = $journals->sum('debit') - $journals->sum('credit');
                        $creditSum = 0;
                    } elseif($account->balance_type == 'Kredit'){
                        $creditSum = $journals->sum('credit') - $journals->sum('debit');
                        $debitSum = 0;
                    }

                        if($previousTrialBalance->account()->where('account_id', $account->id)->first()){
                            $previousTotalDebit = $previousTrialBalance->account()->where('account_id', $account->id)->first()->pivot->debit;
                            $previousTotalCredit = $previousTrialBalance->account()->where('account_id', $account->id)->first()->pivot->credit;
                            
                            if($account->balance_type == 'Debet'){
                                $debitSum = $debitSum + $previousTotalDebit - $previousTotalCredit;
                                $creditSum = 0;
                            } elseif($account->balance_type == 'Kredit'){
                                $creditSum = $creditSum + $previousTotalCredit - $previousTotalDebit;
                                $debitSum = 0;
                            }
                        }
                    

        
                    $this->account()->updateExistingPivot($account->id, [
                        'debit' => $debitSum,
                        'credit' => $creditSum
                    ]);
                    
                } else {
                    if($this->is_first != 1){
                        $this->account()->attach($account->id, [
                            'debit' => 0,
                            'credit' => 0
                        ]);
                    }  
                }
            } 
        }
    }
}
