<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class absensiModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_absensi';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'status',
        'foto',
        'lokasi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(siswaModel::class, 'id_siswa');
    }
}
