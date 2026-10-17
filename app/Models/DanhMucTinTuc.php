<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTinTuc extends Model
{
    use HasFactory;
    protected $table = 'danh_muc_tin_tucs';

    protected $fillable = [
        'id',
        'name',
        'created_at',
    ];
}
