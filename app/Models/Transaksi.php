<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_lokasi',
        'jenis',
        'sumber',
        'nominal',
        'tanggal',
        'keterangan',
    ];

    public function lokasiKos() {
        return $this->belongsTo(LokasiKos::class, 'id_lokasi');
    }
}
