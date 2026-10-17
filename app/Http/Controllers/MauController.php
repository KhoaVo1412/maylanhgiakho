<?php

namespace App\Http\Controllers;

use App\Models\Mau;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Http\Request;
use App\Http\Services\Mau\MauService;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;

class MauController extends Controller
{
    protected $mau;
    public function __construct(MauService $mau)
    {
        $this->mau = $mau;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.mau.list', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Danh Sách Màu',
            'maus'=>$this->mau->get(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.mau.add', [
            'icons'=>'<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm Màu',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tenmau'=>'required',
            'active'=>'required',
            
        ]);

        $this->mau->insert($request);
        return redirect('/admin/mau/list');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Mau $mau)
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.mau.edit', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Sửa Màu: ',
            'mau' => $mau,
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mau $mau)
    {
        
        $this->validate($request, [
            'tenmau'=>'required',
            'active'=>'required',
        ]);

        $result = $this->mau->update($request, $mau);
        if ($result) {
            return redirect('/admin/mau/list');
        }
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = $this->mau->destroy($request);
        if ($result) {
            return response()->json([
                'error'=>false,
                'message'=>'Xóa màu thành công'
            ]);
        }
        return response()->json([
            'error'=>true
        ]);
    }
}
