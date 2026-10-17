<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTThanhToan extends Model
{
    protected $table = 'pt_thanh_toans';
    use HasFactory;
    protected $fillable = [
        'tenthanhtoan',
        'mota',
    ];}
