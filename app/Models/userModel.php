<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class userModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'username',
        'password',
        'role',
        'status',
    ];
}
