<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Bank::insert([
            ['name' => 'BCA', 'account_name' => 'CV. Murni Sejati', 'account_number' => '00001'],
            ['name' => 'BNI', 'account_name' => 'CV. Murni Sejati', 'account_number' => '00002'],
        ]);
    }
}
