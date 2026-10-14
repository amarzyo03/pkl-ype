<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tugasModel extends Model
{
    protected $table = 'tb_tugas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pengirim',
        'judul',
        'deskripsi',
        'file',
    ];
}
