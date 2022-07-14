<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table='tb_mahasiswa';
    protected $primary_key = 'id_mahasiswa';
    public $timestamps = false;
    protected $fillable = [
        'nama_mahasiswa', 'nim_mahasiswa', 'id_user', 'smt_mahasiswa', 'status', 'id_thn_akademik',
    ];
}
