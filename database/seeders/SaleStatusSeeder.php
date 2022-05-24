<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_statuses')->insert([
            ['name' => 'telah terkirim'],
            ['name' => 'menunggu'],
            ['name' => 'dalam pengiriman'],
            ['name' => 'dibatalkan'],
        ]);

        DB::table('payment_statuses')->insert([
            ['name' => 'lunas'],
            ['name' => 'menunggu pembayaran'],
            ['name' => 'menunggu konfirmasi'],
            ['name' => 'dibatalkan'],
        ]);
    }
}
