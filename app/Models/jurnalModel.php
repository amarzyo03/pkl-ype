<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class jurnalModel extends Model
{
    use SoftDeletes;

    protected $table = 'tb_jurnal';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'kegiatan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(siswaModel::class, 'id_siswa');
    }
}
