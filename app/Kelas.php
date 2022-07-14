<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table='tb_kelas';
    protected $primary_key = 'id_kelas';
    public $timestamps = false;
    protected $fillable = [
        'kode_kelas', 'id_mata_kuliah', 'id_prodi', 'id_thn_akademik',
    ];
}
