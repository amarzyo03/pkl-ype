<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kelasModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_kelas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'id_jurusan',
    ];

    public function jurusan()
    {
        return $this->belongsTo(jurusanModel::class, 'id_jurusan');
    }
}
