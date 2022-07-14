<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetKelas extends Model
{
    protected $table='tb_det_kelas';
    protected $primary_key = 'id_det_kelas';
    public $timestamps = false;
    protected $fillable = [
        'id_kelas', 'id_mahasiswa', 
    ];
}
