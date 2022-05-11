<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 
        'user_id', 
        'destination_bank', 
        'sender_bank', 
        'sender_account_name', 
        'sender_account_number', 
        'date', 
        'transfer_proof'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function getSaleNumber()
    {
        return $this->sale->sale_number;
    }
}
