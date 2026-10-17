<?php


namespace App\Http\Services\Productt;


use App\Models\BienThe;
use App\Models\Mau;
use App\Models\Productt;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class ProducttService
{
    const LIMIT = 300;

    public function get($page = null)
    {
        return Productt::select(
            'id', 'name', 'price', 'price_sale', 'thumb', 'slug', 'menu_id',
            'maluc', 'loaigas', 'xuatxu', 'tgbh', 'model', 'view', 'description'
        )
            ->where('active', 1)
            ->orderByDesc('id')
            ->when($page !== null && $page > 0, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }

   public function show($slug)
    {
        return Productt::where('slug', $slug)
            ->where('active', 1)
            ->with('menu')
            ->firstOrFail();
    }
    public function getRelated($slug)
    {
        $menu_id = Productt::where('slug', $slug)->value('menu_id');

        $relatedProducts = Productt::where('menu_id', $menu_id)
            ->where('slug', '!=', $slug)
            ->get();
        return $relatedProducts;
    }
    public function more($slug)
    {
        $current_product = Productt::where('slug', $slug)->first();

        return Productt::select('id', 'name', 'price', 'price_sale', 'thumb','slug')
            ->where('active', 1)
            ->where('id', '!=', $current_product->id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();
    }
    // public function getSize($id)
    // {
    //   $idsize=BienThe::select('size_id')->where('san_pham_id', '=', $id)->distinct()->get();
    //   foreach($idsize as $ids){
    //     $tam[]=Size::select('id', 'tensize')->where('id',$ids->size_id)->get();
    //   }
    //     return $tam;

    // }
    public function getscaper($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 18)
            ->where('SL', 113)
            ->orderByDesc('id')
            ->get();
    }
    public function getsharp($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 12)
            ->where('SL', 114)
            ->orderByDesc('id')
            ->get();
    }
    public function getnagakawa($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 17)
            ->where('SL', 115)
            ->orderByDesc('id')
            ->get();
    }
    public function getcomfee($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 13)
            ->where('SL', 116)
            ->orderByDesc('id')
            ->get();
    }
    public function gettosiba($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 4)
            ->where('SL', 117)
            ->orderByDesc('id')
            ->get();
    }
    public function getcasperqc($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 18)
            ->where('SL', 118)
            ->orderByDesc('id')
            ->get();
    }
    public function getmitsubishi($slug)
    {

        return Productt::select('id', 'price_sale', 'name', 'maluc','slug')
            ->where('menu_id', '=', 24)
            ->where('SL', 119)
            ->orderByDesc('id')
            ->get();
    }
     
}
