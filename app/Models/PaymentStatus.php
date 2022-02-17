<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    public const LUNAS = 1;
    public const MENUNGGU_PEMBAYARAN = 2;
    public const MENUNGGU_KONFIRMASI = 3;
    public const DIBATALKAN = 4;
}
