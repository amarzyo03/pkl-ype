<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class guruMapelKelasModel extends Model
{
    use SoftDeletes;

    protected $table = 'tr_guru_mapel_kelas';

    protected $fillable = [
        'id_guru',
        'id_mapel',
        'id_kelas',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(guruModel::class, 'id_guru')->withTrashed();
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(mapelModel::class, 'id_mapel')->withTrashed();
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(kelasModel::class, 'id_kelas')->withTrashed();
    }
}
