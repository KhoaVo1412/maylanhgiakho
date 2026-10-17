<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    use HasFactory;
    protected $table = 'tin_tucs';

    protected $fillable = [
        'id',
        'name',
        'image',
        'description',
        'detail_descriptions',
        'slug',
        'danh_muc_tin_tuc_id',
        'created_at',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMucTinTuc::class, 'danh_muc_tin_tuc_id')->withDefault([
            'name' => 'Cẩm Nang Máy Lạnh',
        ]);
    }
}
