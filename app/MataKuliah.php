<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table='tb_mata_kuliah';
    protected $primary_key = 'id_mata_kuliah';
    public $timestamps = false;
    protected $fillable = [
        'kode_mata_kuliah', 'mata_kuliah', 'id_prodi',
    ];
}
