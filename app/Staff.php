<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table='tb_staff';
    protected $primary_key = 'id_staff';
    public $timestamps = false;
    protected $fillable = [
        'nama_staff', 'id_user', 'status', 'jenis_staff',
    ];
}
