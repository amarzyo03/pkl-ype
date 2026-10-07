<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class guruModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_guru';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'username',
        'password',
    ];
}
