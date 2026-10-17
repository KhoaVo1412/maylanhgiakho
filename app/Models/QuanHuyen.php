<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    use HasFactory;
    public $table = 'quan_huyens';
    public $primaryKey = 'id';
    public $fillable = [
        'id',
        'tenqh',
        'tinh_tp_id',
    ];
}
