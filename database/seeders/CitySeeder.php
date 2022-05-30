<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = Province::create(['name' => 'Bali']);
        $jawa = Province::create(['name' => 'Jawa']);
        City::insert([
            ['province_id' => $province->id, 'name' => 'Denpasar'],
            ['province_id' => $province->id, 'name' => 'Badung'],
            ['province_id' => $province->id, 'name' => 'Gianyar'],
            ['province_id' => $province->id, 'name' => 'Amlapura'],
            ['province_id' => $province->id, 'name' => 'Klungkung'],
            ['province_id' => $province->id, 'name' => 'Negare'],
            ['province_id' => $province->id, 'name' => 'Semarapura'],
            ['province_id' => $province->id, 'name' => 'Kuta'],
            ['province_id' => $province->id, 'name' => 'Jimbaran'],
            ['province_id' => $province->id, 'name' => 'Canggu'],
            ['province_id' => $province->id, 'name' => 'Seminyak'],
            ['province_id' => $province->id, 'name' => 'Tabanan'],
            ['province_id' => $province->id, 'name' => 'Nusa Dua'],
            ['province_id' => $jawa->id, 'name' => 'Bandung'],
            ['province_id' => $jawa->id, 'name' => 'Jakarta'],
            ['province_id' => $jawa->id, 'name' => 'Malang'],
        ]);
    }
}
