<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;
    protected $table = 'hoa_dons';
    protected $fillable = [
        'user_id',
        'pt_thanh_toan_id',
        'ds_trang_thai_id',
        'thoigian',
        'tongtien',
        'tiengg',
        'tientra',
        'id',
        // 'ds_trang_thai_id',
        

    ];
}
