<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiKosSeeder extends Seeder
{
    public function run()
    {
        DB::table('lokasi_kos')->insert([
            [
                'nama_kos' => 'Kos Mewah A',
                'alamat' => 'Jl. Anggrek No. 10, Jakarta',
                'kapasitas_total' => 20,
                'kontak_pengelola' => '081234567890',
            ],
            [
                'nama_kos' => 'Kos Hemat B',
                'alamat' => 'Jl. Melati No. 15, Bandung',
                'kapasitas_total' => 15,
                'kontak_pengelola' => '081987654321',
            ],
        ]);
    }
}