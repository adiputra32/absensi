<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsensiKelas extends Model
{
    protected $table='tb_absensi_kelas';
    protected $primary_key = 'id_absensi_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_kelas', 'mulai', 'selesai', 'status', 'materi', 'metode',
    ];
}
