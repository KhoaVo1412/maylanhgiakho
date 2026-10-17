<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Http\Request;
use App\Http\Services\coupon\CouponService;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;

class CouponController extends Controller
{
    protected $coupon;
    public function __construct(CouponService $coupon)
    {
        $this->coupon = $coupon;
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
        return view('admin.giamgia.list', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Danh Sách Giảm Giá',
            'sizes'=>$this->coupon->get(),
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
        return view('admin.giamgia.add', [
            'icons'=>'<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm Giảm Giá',
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
        // $this->validate($request, [
        //     'tengg'=>'required',
        //     'active'=>'required',
            
        // ]);

        $this->coupon->insert($request);
        return redirect('/admin/giamgia/list');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $giamgia)
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.giamgia.edit', [
            'icons'=>'<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Sửa Giảm Giá ',
            'size' => $giamgia,
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
    public function update(Request $request, Coupon $giamgia)
    {
        
        // $this->validate($request, [
        //     'tengg'=>'required',
        //     'active'=>'required',
        // ]);

        $result = $this->coupon->update($request, $giamgia);
        if ($result) {
            return redirect('/admin/giamgia/list');
        }
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = $this->coupon->destroy($request);
        if ($result) {
            return response()->json([
                'error'=>false,
                'message'=>'Xóa giảm giá thành công'
            ]);
        }
        return response()->json([
            'error'=>true
        ]);
    }
}
