<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'account_number', 'account_name'];

    public const BANK = [
        'BCA' => 'BCA',
        'Mandiri' => 'Mandiri',
        'BNI' => 'BNI',
        'BRI' => 'BRI',
        'Panin' => 'Panin',
        'CIMB Niaga' => 'CIMB Niaga',
        'Bank Permata' => 'Bank Permata',
        'Citibank Indonesia' => 'Citibank Indonesia'
    ];
}
