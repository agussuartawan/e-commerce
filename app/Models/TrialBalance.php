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
                $debitSum = $journals->sum('debit');
                $creditSum = $journals->sum('credit');
    
                $this->account()->updateExistingPivot($account->id, [
                    'debit' => $debitSum,
                    'credit' => $creditSum
                ]);
            }
        } 
    }
}
