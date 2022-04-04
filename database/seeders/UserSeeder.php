<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::transaction(function () {
			$beranda = Permission::create(['name' => 'akses beranda']);
			$kategori = Permission::create(['name' => 'akses kategori']);
			$barang = Permission::create(['name' => 'akses barang']);
			$akun = Permission::create(['name' => 'akses akun']);
			$pelanggan = Permission::create(['name' => 'akses pelanggan']);
			$bank = Permission::create(['name' => 'akses bank']);
			$pembayaran = Permission::create(['name' => 'akses pembayaran']);
			$penjualan = Permission::create(['name' => 'akses penjualan']);
			$jurnal_umum = Permission::create(['name' => 'akses jurnal umum']);

			$laporan_penjualan = Permission::create(['name' => 'akses laporan penjualan']);
			$laporan_jurnal_umum = Permission::create(['name' => 'akses laporan jurnal umum']);
			$laporan_neraca_saldo = Permission::create(['name' => 'akses laporan neraca saldo']);
			$laporan_buku_besar = Permission::create(['name' => 'akses laporan buku besar']);

			$dashboard = Permission::create(['name' => 'akses dashboard']);
			$user = Permission::create(['name' => 'akses user']);
			$daerah = Permission::create(['name' => 'akses daerah']);

			$superadmin_role = Role::create(['name' => 'Super Admin']);
			$admin_role = Role::create(['name' => 'Admin']);
			$accounting_role = Role::create(['name' => 'Accounting']);
			$warehouse_role = Role::create(['name' => 'Staff Gudang']);
			$owner_role = Role::create(['name' => 'Owner']);
			$customer_role = Role::create(['name' => 'Pelanggan']);

			$admin_role->syncPermissions([$bank, $pelanggan, $pembayaran, $penjualan, $dashboard, $daerah, $laporan_penjualan]);
			$accounting_role->syncPermissions([
				$laporan_penjualan, $laporan_buku_besar, $laporan_jurnal_umum, $laporan_neraca_saldo, $jurnal_umum, $akun, $dashboard
			]);
			$warehouse_role->syncPermissions([$kategori, $barang, $dashboard]);
			$owner_role->syncPermissions([
				$laporan_penjualan, $laporan_buku_besar, $laporan_jurnal_umum, $laporan_neraca_saldo, $user, $dashboard
			]);
			$customer_role->syncPermissions([$beranda]);

			$superadmin = User::create([
				'name' => 'Super Admin',
				'email' => 'superadmin@gmail.com',
				'password' => Hash::make('password')
			]);

			$admin = User::create([
				'name' => 'Admin',
				'email' => 'admin@gmail.com',
				'password' => Hash::make('password')
			]);

			$warehouse = User::create([
				'name' => 'Staff Gudang',
				'email' => 'warehouse@gmail.com',
				'password' => Hash::make('password')
			]);

			$accounting = User::create([
				'name' => 'Akunting',
				'email' => 'accounting@gmail.com',
				'password' => Hash::make('password')
			]);

			$owner = User::create([
				'name' => 'Owner',
				'email' => 'owner@gmail.com',
				'password' => Hash::make('password')
			]);

			$superadmin->assignRole($superadmin_role);
			$admin->assignRole($admin_role);
			$warehouse->assignRole($warehouse_role);
			$accounting->assignRole($accounting_role);
			$owner->assignRole($owner_role);
		});
	}
}
