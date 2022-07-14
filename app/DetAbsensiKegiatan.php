<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetAbsensiKegiatan extends Model
{    
    protected $table='tb_det_absensi_kegiatan';
    protected $primary_key = 'id_det_absensi_kegiatan';
    public $timestamps = true;
    protected $fillable = [
        'id_absensi_kegiatan', 'id_staff', 'id_dosen', 'absensi', 'created_at', 'updated_at',
    ];
}
