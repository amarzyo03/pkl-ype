<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class dudiModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_dudi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'bidang_usaha',
        'alamat',
        'telepon',
        'email',
    ];
}
