<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';
    protected $timestamp = false;

    protected $fillable = [
        'id_lokasi',
        'nomor_kamar',
        'tipe_kamar',
        'fasilitas',
        'harga',
        'status',
    ];
    
    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'id_lokasi', 'id_lokasi');
    }
}
