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
            ['name' => 'Mandiri', 'account_name' => 'CV. Murni Sejati', 'account_number' => '00002'],
            ['name' => 'BNI', 'account_name' => 'CV. Murni Sejati', 'account_number' => '00003'],
            ['name' => 'BRI', 'account_name' => 'CV. Murni Sejati', 'account_number' => '00004'],
        ]);
    }
}
