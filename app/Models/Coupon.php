<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =[
        'tengg','magg','slgg','tngg','sotiengg','active'
    ];
    protected $primarykey = 'id';
    protected $table = 'coupons';
}
