<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienThe extends Model
{
    protected $table = 'bien_thes';
    use HasFactory;
    protected $fillable = [
        'san_pham_id',
        'size_id',
        'mau_id',
        'SL'
    ];
}
