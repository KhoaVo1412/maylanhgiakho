<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSTrangThai extends Model
{
    protected $table = 'ds_trang_thais';
    use HasFactory;
    protected $fillable = [
        'tenTT',
        'mota',
    ];}
