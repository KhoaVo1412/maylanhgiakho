<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTHoaDon extends Model
{
    use HasFactory;
    protected $table = 'ct_hoa_dons';
    protected $fillable = [
        'content',
        'email',
        'address',
        'phone',
        'name',
        'hoa_don_id',
        'product_id',
        'size',
        'mau',
        'SL',
        'gia',
        'thanhtien'

    ];
}
