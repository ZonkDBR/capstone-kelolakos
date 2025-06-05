<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';
    protected $guarded = ['id_penghuni'];
    protected $primaryKey = 'id_penghuni';

    public function sewa()
    {
        return $this->hasMany(Sewa::class, 'id_penghuni');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'id_lokasi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
