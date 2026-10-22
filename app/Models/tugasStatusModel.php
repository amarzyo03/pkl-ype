<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tugasStatusModel extends Model
{
    use SoftDeletes;

    protected $table = 'tb_tugas_status';

    protected $fillable = [
        'id_siswa',
        'id_tugas',
        'tanggal',
        'status',
        'file',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }
}
