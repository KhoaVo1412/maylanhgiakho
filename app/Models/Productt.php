<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productt extends Model
{
    use HasFactory;
        public $table = 'productts';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb',
        'SL',
        'view',
        'model',
        'mausac',
        'nsx',
        'xuatxu',
        'namramat',
        'tgbh',
        'ddiembh',
        'loaigas',
        'khumui',
        'thumb_dt1',
        'thumb_dt2',
        'maluc',
    ];
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
        ->withDefault(['name' => '']);
    }
}
