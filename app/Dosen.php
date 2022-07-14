<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table='tb_dosen';
    protected $primary_key = 'id_dosen';
    public $timestamps = false;
    protected $fillable = [
        'nama_dosen', 'nidn', 'id_user', 'jenis_dosen', 'status',
    ];
}
