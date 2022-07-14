<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsensiKegiatan extends Model
{
    protected $table='tb_absensi_kegiatan';
    protected $primary_key = 'id_absensi_kegiatan';
    public $timestamps = false;
    protected $fillable = [
        'id_kegiatan', 'nama_kegiatan', 'id_staff', 'mulai', 'selesai', 'status',
    ];
}
