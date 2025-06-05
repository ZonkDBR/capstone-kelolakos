<?php

namespace Database\Seeders;

// Seeder: TbKamarSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    public function run()
    {
        DB::table('kamar')->insert([
            [
                'id_lokasi' => 1,
                'nomor_kamar' => '101',
                'tipe_kamar' => 'Standard',
                'harga' => 500000.00,
                'status' => 'Kosong',
            ],
            [
                'id_lokasi' => 1,
                'nomor_kamar' => '102',
                'tipe_kamar' => 'Deluxe',
                'harga' => 700000.00,
                'status' => 'Terisi',
            ],
            [
                'id_lokasi' => 2,
                'nomor_kamar' => '201',
                'tipe_kamar' => 'Standard',
                'harga' => 400000.00,
                'status' => 'Kosong',
            ],
        ]);
    }
}
