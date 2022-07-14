<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table='tb_prodi';
    protected $primary_key = 'id_prodi';
    public $timestamps = false;
    protected $fillable = [
        'prodi',
    ];
}
