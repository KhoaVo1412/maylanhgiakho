<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    use HasFactory;
    protected $table = 'dich_vus';

    protected $fillable = [
        'id',
        'name',
        'image',
        'description',
        'detail_descriptions',
        'slug',
        'type',
        'created_at',
    ];
}
