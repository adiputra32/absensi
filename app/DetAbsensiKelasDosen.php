<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetAbsensiKelasDosen extends Model
{
    protected $table='tb_det_absensi_kelas_dosen';
    protected $primary_key = 'id_det_absensi_kelas_dosen';
    public $timestamps = true;
    protected $fillable = [
        'id_absensi_kelas', 'id_dosen', 'absensi', 'created_at', 'updated_at',
    ];
}
