<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
    public function index(Request $request, $slug)
    {
        $menu = $this->menuService->getId($slug);
        $productts = $this->menuService->getProduct($menu, $request);
        $allMenus = $this->menuService->show();

        return view('menu',[
            'title'=>$menu->name,
            'productts'=>$productts,
            'menu'=>$menu,
            'menus'=>$allMenus
        ]);
    }
}
