<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $table = 'sewa';
    protected $primaryKey = 'id_sewa';
    protected $fillable = [
        'id_penghuni',
        'id_kamar',
        'tanggal_sewa',
        'tanggal_selesai',
        'status',
        'status_pembayaran' // Add this line
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id_penghuni');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }
}