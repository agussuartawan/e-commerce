<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['account_type_id', 'name', 'account_number', 'description'];

    public function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function trial_balance()
    {
        return $this->belongsToMany(TrialBalance::class)->withPivot('credit', 'debit');
    }

    public function general_journal()
    {
        return $this->hasMany(GeneralJournal::class);
    }

    public function accountUsed()
    {
        if(
            is_null(
                \DB::table('account_trial_balance')
                    ->where('account_id', $this->id)
                    ->first()
            )
            &&
            is_null(
                \DB::table('general_journals')
                    ->where('account_id', $this->id)
                    ->first()
            )
        ){
            return true;
        }
        return false;
    }

    public const KAS = 2;
    public const PENJUALAN = 18;
}

