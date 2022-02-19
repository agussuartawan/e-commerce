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
                'name' => 'Aset Lancar',
                'account_number' => '1-101',
                'description' => 'Aset Lancar'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Kas',
                'account_number' => '1-102',
                'description' => 'Kas'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Piutang Dagang',
                'account_number' => '1-103',
                'description' => 'Piutang Dagang'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Perlengkapan Kantor',
                'account_number' => '1-104',
                'description' => 'Perlengkapan Kantor'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Iklan Dibayar Dimuka',
                'account_number' => '1-105',
                'description' => 'Iklan Dibayar Dimuka'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Asuransi Dibayar Dimuka',
                'account_number' => '1-106',
                'description' => 'Asuransi Dibayar Dimuka'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Aset Tetap',
                'account_number' => '1-201',
                'description' => 'Aset Tetap'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Tanah',
                'account_number' => '1-202',
                'description' => 'Tanah'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Gedung',
                'account_number' => '1-203',
                'description' => 'Gedung'
            ],
            [
                'account_type_id' => 1,
                'name' => 'Akumulas Penyusutan Gedung',
                'account_number' => '1-204',
                'description' => 'Akumulas Penyusutan Gedung'
            ],

            // utang
            [
                'account_type_id' => 2,
                'name' => 'Kewajiban',
                'account_number' => '2-101',
                'description' => 'Kewajiban'
            ],
            [
                'account_type_id' => 2,
                'name' => 'Kewajiban Lancar',
                'account_number' => '2-102',
                'description' => 'Kewajiban Lancar'
            ],
            [
                'account_type_id' => 2,
                'name' => 'Utang Usaha',
                'account_number' => '2-103',
                'description' => 'Utang Usaha'
            ],
            [
                'account_type_id' => 2,
                'name' => 'Utang Gaji dan Komisi',
                'account_number' => '2-104',
                'description' => 'Utang Gaji dan Komisi'
            ],

            //modal
            [
                'account_type_id' => 3,
                'name' => 'Modal Usaha',
                'account_number' => '3-101',
                'description' => 'Modal Usaha'
            ],
            [
                'account_type_id' => 3,
                'name' => 'Prive',
                'account_number' => '3-102',
                'description' => 'Prive'
            ],

            //pendapatan
            [
                'account_type_id' => 4,
                'name' => 'Pendapatan Jasa',
                'account_number' => '4-101',
                'description' => 'Pendapatan Jasa'
            ],
            [
                'account_type_id' => 4,
                'name' => 'Penjualan Barang',
                'account_number' => '4-402',
                'description' => 'Penjualan Barang'
            ],

            //biaya
            [
                'account_type_id' => 5,
                'name' => 'Biaya Gaji dan Komisi',
                'account_number' => '5-101',
                'description' => 'Biaya Gaji dan Komisi'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Sewa',
                'account_number' => '5-102',
                'description' => 'Biaya Sewa'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Iklan',
                'account_number' => '5-103',
                'description' => 'Biaya Iklan'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Kendaraan',
                'account_number' => '5-104',
                'description' => 'Biaya Kendaraan'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Lainnya',
                'account_number' => '5-105',
                'description' => 'Biaya Lainnya'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Perlengkapan Kantor',
                'account_number' => '5-106',
                'description' => 'Biaya Perlengkapan Kantor'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Penyusutan Gedung',
                'account_number' => '5-107',
                'description' => 'Biaya Penyusutan Gedung'
            ],
            [
                'account_type_id' => 5,
                'name' => 'Biaya Asuransi',
                'account_number' => '5-108',
                'description' => 'Biaya Asuransi'
            ],
        ]);
    }
}
