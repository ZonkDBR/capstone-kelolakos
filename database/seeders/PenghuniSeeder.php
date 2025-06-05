<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penghuni')->insert([
            [
                'id_kamar' => 2,
                'id_lokasi' => 1,
                'id_user' => 2,
                'nama_penghuni' => 'Budi Santoso',
                'no_ktp' => '1234567890123456',
                'no_hp' => '081212345678',
                'alamat_asal' => 'Surabaya',
            ],
            [
                'id_kamar' => null,
                'id_lokasi' => 2,
                'id_user' => 3,
                'nama_penghuni' => 'Siti Aminah',
                'no_ktp' => '9876543210987654',
                'no_hp' => '081298765432',
                'alamat_asal' => 'Yogyakarta',
            ],
        ]);
    }
}
