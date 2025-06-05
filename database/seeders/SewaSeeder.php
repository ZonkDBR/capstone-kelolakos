<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sewa')->insert([
            [
                'id_penghuni' => 1,
                'id_kamar' => 2,
                'tanggal_sewa' => '2025-01-01',
                'tanggal_selesai' => null,
                'status' => 'Aktif'
            ],
        ]);
    }
}
