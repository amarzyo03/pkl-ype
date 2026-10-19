<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class dudiModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tb_dudi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'alamat',
        'telp',
        'pic',
        'id_jurusan',
        'id_guru',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(jurusanModel::class, 'id_jurusan');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(guruModel::class, 'id_guru');
    }
}
