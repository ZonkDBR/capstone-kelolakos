<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksi')->insert([
            [
                'id_lokasi' => 1,
                'jenis' => 'Pemasukan',
                'sumber' => 'Pembayaran Kos',
                'nominal' => 700000.00,
                'tanggal' => '2025-01-01',
                'keterangan' => 'Pembayaran Januari 2025'
            ]
        ]);
    }
}
