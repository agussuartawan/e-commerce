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
        return $this->belongsToMany(TrialBalance::class);
    }

    public function general_journal()
    {
        return $this->hasMany(GeneralJournal::class);
    }
}

