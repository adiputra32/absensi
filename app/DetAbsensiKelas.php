<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetAbsensiKelas extends Model
{
    protected $table='tb_det_absensi_kelas';
    protected $primary_key = 'id_det_absensi_kelas';
    public $timestamps = true;
    protected $fillable = [
        'id_absensi_kelas', 'id_mahasiswa', 'absensi', 'created_at', 'updated_at',
    ];
}
