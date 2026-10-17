<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhTP extends Model
{
    use HasFactory;
    protected $table = 'tinh_tps';
    public $primaryKey = 'id';
    public $fillable = [
        'id',
        'tentp',
    ];

    public function sections()
    {
        return $this->hasMany(QuanHuyen::class);
    }
}
