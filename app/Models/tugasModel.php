<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class tugasModel extends Model
{
    use SoftDeletes;

    protected $table = 'tb_tugas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_guru',
        'tanggal',
        'judul',
        'deskripsi',
        'file',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(guruModel::class, 'id_guru')->withTrashed();
    }
}
