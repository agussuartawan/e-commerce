<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountType::insert([
            [
                'name' => 'Aset',
                'account_number' => 1,
                'balance_type' => 'Debet'
            ],
            [
                'name' => 'Utang',
                'account_number' => 2,
                'balance_type' => 'Kredit'
            ],
            [
                'name' => 'Modal',
                'account_number' => 3,
                'balance_type' => 'Kredit'
            ],
            [
                'name' => 'Pendapatan',
                'account_number' => 4,
                'balance_type' => 'Kredit'
            ],
            [
                'name' => 'Biaya atau Beban',
                'account_number' => 5,
                'balance_type' => 'Debet'
            ],
        ]);

        Account::insert([
            [
                'account_type_id' => 1,
                'name' => 'Kas',
                'account_number',
                'description'
            ]
        ]);
    }
}
