<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiKos extends Model
{
    
    protected $primaryKey = 'id_lokasi';

    protected $table = 'lokasi_kos';

    protected $guarded = ['id_lokasi'];
}
