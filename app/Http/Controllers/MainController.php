<?php

namespace App\Http\Controllers;

use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Productt\ProducttService;

class MainController extends Controller
{
    protected $productt;
    protected $slider;
    protected $menu;
    public function __construct(SliderService $slider, MenuService $menu, ProducttService $productt)
    {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->productt = $productt;
    }

    

    public function index()
    {
        return view('home', [
            'title' => "Máy Lạnh Giá Kho",
            'sliders' => $this->slider->show(),
            'menus' => $this->menu->show(),
            'productts' => $this->productt->get()
        ]);
    }
    public function loadProduct(Request $request)
    {
        $page = (int)$request->input('page', 0);
        $result = $this->productt->get($page);

        if ($request->input('format') === 'json' || $request->wantsJson()) {
            return response()->json([
                'products' => $result,
                'count' => count($result)
            ]);
        }

        if(count($result) != 0){
            $html = view('productts.list', ['productts' => $result])->render();

            return response()->json([
                'html'=> $html
            ]);
        }
        return response()->json(['html'=>'']);
    }
}
