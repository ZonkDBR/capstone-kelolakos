<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            [
                'id_sewa' => 1,
                'tanggal_bayar' => '2025-01-01',
                'nominal' => 700000.00,
                'periode_bayar' => 'Januari 2025',
                'status' => 'Lunas',
                'id_transaksi' => null,
            ],
        ]);
    }
}
