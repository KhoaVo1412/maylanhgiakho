<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'product_id',
        'pty',
        'price',
        'size',
        'mau',
        'pt_thanh_toan_id',
        'ds_trang_thai_id',
    ];

    public function product()
    {
        return $this->hasOne(Productt::class, 'id', 'product_id');
    }
}
