<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    protected $table='tb_pengampu';
    protected $primary_key = 'id_pengampu';
    public $timestamps = false;
    protected $fillable = [
        'id_dosen', 'id_kelas', 'status',
    ];
}
