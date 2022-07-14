<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table='tb_thn_akademik';
    protected $primary_key = 'id_thn_akademik';
    public $timestamps = false;
    protected $fillable = [
        'thn_akademik_1', 'thn_akademik_2', 'angkatan', 'semester',
    ];
}
