<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comment';
    use HasFactory;
    public $fillable=[
        'comment_name',
        'comment_time',
        'comment_product',
        'comment_ct',
    ];
}
