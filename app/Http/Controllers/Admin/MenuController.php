<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Menu;
use App\Models\Productt;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class MenuController extends Controller
{

    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function create()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.menu.add', [
            'icons'=>'<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title'=>'Thêm Loại Sản Phẩm',
            'menus'=> $this->menuService->getParent(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $this->menuService->create($request);

        return redirect('/admin/menus/list');
        // return redirect()->back();
    }

    public function index()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.menu.list', [
            'icons'=>'<i class="nav-icon fas fa-tachometer-alt"></i>',
            'title'=>'Danh Sách Loại Sản Phẩm',
            'menus'=>$this->menuService->getAll(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function show(Menu $menu)
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        return view('admin.menu.edit', [
            'icons'=>'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
            'title'=>'Sửa Loại : ' . $menu->name,
            'menu'=>$menu,
            'menus'=> $this->menuService->getParent(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request)
    {

        $this->menuService->update($request, $menu);
        
        return redirect('/admin/menus/list');
    }

    public function destroy(Request $request): JsonResponse
    {
        $result = $this->menuService->destroy($request);
        if ($result) {
            return response()->json([
                'error'=>false,
                'message'=>'Xóa thành công'
            ]);
        }
        return response()->json([
            'error'=>true,
        ]);
    } 
}
