<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuongXa extends Model
{
    use HasFactory;
    public $table = 'phuong_xas';
    public $primaryKey = 'id';
    public $fillable = [
        'id',
        'tenpx',
        'quan_huyen_id',
    ];
}
