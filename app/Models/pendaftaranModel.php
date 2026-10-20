<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class pendaftaranModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_pendaftaran';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'id_dudi',
        'status',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(siswaModel::class, 'id_siswa');
    }

    public function dudi(): BelongsTo
    {
        return $this->belongsTo(dudiModel::class, 'id_dudi');
    }
}
