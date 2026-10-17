<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'size_id',
        'mau_id',

    ];
}
