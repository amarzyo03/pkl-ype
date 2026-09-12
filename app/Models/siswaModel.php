<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'kelas',
        'username',
        'password',
        'status'
    ];
}
