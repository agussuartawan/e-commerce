<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    use HasFactory;

    public const DIKIRIM = 1;
    public const MENUNGGU = 2;
    public const DALAM_PENGIRIMAN = 3;
    public const DIBATALKAN = 4;
}
