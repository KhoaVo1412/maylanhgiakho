<?php

namespace App\Http\Controllers;

use App\Models\Productt;
use App\Http\Requests\StoreBienTheRequest;
use App\Http\Requests\UpdateBienTheRequest;
use App\Http\Services\Bienthe\BTService;
use App\Models\BienThe;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\User;
use Illuminate\Http\Request;

class BienTheController extends Controller
{
    protected $btService;

    public function __construct(BTService $btService)
    {
        $this->btService = $btService;
    }

    public function index()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.ctsp.list', [
            'icons'=>'<i class="nav-icon fas fa-store-alt"></i>',
            'title' => 'Danh Sách CTSP',
            'ctsps' => $this->btService->get(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function create()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','ASC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.ctsp.add', [
            'icons'=>'<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm CTSP',
            'sps' => $this->btService->getSP(),
            'sizes' => $this->btService->getSize(),
            'maus' => $this->btService->getMau(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }
    public function store(Request $request)
    {
        $this->btService->insert($request);

        return redirect('/admin/ctsp/list');
    }

    public function show(BienThe $ctsp)
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.ctsp.edit', [
            'icons'=>'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',
            'title' => 'Sửa CTSP: ',
            'ctsp' => $ctsp,
            'sps' => $this->btService->getSP(),
            'sizes' => $this->btService->getSize(),
            'maus' => $this->btService->getMau(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl

        ]);
    }
    public function update(Request $request, BienThe $ctsp)
    {
        $result = $this->btService->update($request, $ctsp);
        if($result)
        {
            return redirect('/admin/ctsp/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->btService->delete($request);
        if ($result) {
            return response()->json([
                'error'=>false,
                'message'=>'Xóa CTSP thành công'
            ]);
        }
        return response()->json(['error'=>true]);

    }
}
