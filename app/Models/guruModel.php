<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class guruModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_guru';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'id_jurusan',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(jurusanModel::class, 'id_jurusan');
    }

    public function tugas()
    {
        return $this->hasMany(tugasModel::class, 'id_guru', 'id');
    }
}
