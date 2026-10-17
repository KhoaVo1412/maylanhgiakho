<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\Menu\MenuService;
class Menu extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'parent_id',
        'description',
        'title',
        'content',
        'slug',
        'active',
        'thumb',
    ];
    public function productts()
    {
        return $this->hasMany(Productt::class, 'menu_id', 'id');
    }
}
