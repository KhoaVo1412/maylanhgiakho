<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Http\Request;
use App\Http\Services\Size\SizeService;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;

class SizeController extends Controller
{
    protected $size;
    public function __construct(SizeService $size)
    {
        $this->size = $size;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.size.list', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Danh Sách Size',
            'sizes'=>$this->size->get(),
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
    { $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.size.add', [
            'icons'=>'<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm Size',
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
            'tensize'=>'required',
            'active'=>'required',
            
        ]);

        $this->size->insert($request);
        return redirect('/admin/size/list');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.size.edit', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Sửa Size: ',
            'size' => $size,
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
    public function update(Request $request, Size $size)
    {
        
        $this->validate($request, [
            'tensize'=>'required',
            'active'=>'required',
        ]);

        $result = $this->size->update($request, $size);
        if ($result) {
            return redirect('/admin/size/list');
        }
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = $this->size->destroy($request);
        if ($result) {
            return response()->json([
                'error'=>false,
                'message'=>'Xóa Size thành công'
            ]);
        }
        return response()->json([
            'error'=>true
        ]);
    }
}
