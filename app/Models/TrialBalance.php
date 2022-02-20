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
}
