<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class mapelModel extends Model
{
    use hasFactory;
    use softDeletes;

    protected $table = 'tb_mapel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'jenis',
    ];

    public function guru()
    {
        return $this->belongsToMany(guruModel::class, 'id_mapel');
    }
}
