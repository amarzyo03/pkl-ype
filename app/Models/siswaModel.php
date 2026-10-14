<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class siswaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_siswa';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'id_kelas',
        'username',
        'password',
        'status',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(kelasModel::class, 'id_kelas')->withTrashed();
    }
}
