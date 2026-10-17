<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreHoaDonRequest;
use App\Http\Requests\UpdateHoaDonRequest;
use App\Models\BienThe;
use App\Models\CTHoaDon;
use App\Models\DSTrangThai;
use App\Models\Productt;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function test()
    { Session::forget('coupon');
        Cart::destroy();

    }
    public function index()
    {
        
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id', $user_id)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.ds_trang_thai_id')
        ->orderBy('hoa_dons.id','desc')
        ->paginate(6);
        return view('history.history_order',[
            'hoadons' => $layhd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }
    public function DangXuLy()
    {
        
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id','=', $user_id)
        ->where('ds_trang_thai_id','=', 1)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.ds_trang_thai_id')
        ->orderBy('hoa_dons.id','desc')

        ->paginate(10);
        return view('history.dang_xu_ly',[
            'hoadons_dxl' => $layhd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }

    public function DaHuyHD()
    {
        
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id', $user_id)
        ->where('ds_trang_thai_id', 4)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.ds_trang_thai_id')
        ->orderBy('hoa_dons.id','desc')
        ->paginate(10);
        return view('history.da_huy',[
            'hoadons_dh' => $layhd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }

    public function DangGiaoHang()
    {
        
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id', $user_id)
        ->where('ds_trang_thai_id', 2)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.ds_trang_thai_id')
        ->orderBy('hoa_dons.id','desc')
        ->paginate(10);
        return view('history.dang_giao',[
            'hoadons_dg' => $layhd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }

    public function HoaDonDaHoanThanh()
    {
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id', $user_id)
        ->where('ds_trang_thai_id', 3)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.ds_trang_thai_id')
        ->orderBy('hoa_dons.id','desc')
        ->paginate(10);
        return view('history.da_hoan_thanh',[
            'hoadons_ht' => $layhd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }

    public function showdetail(HoaDon $hoadon)
    {
        $cthd = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->select('ct_hoa_dons.name','ct_hoa_dons.phone','ct_hoa_dons.email','ct_hoa_dons.address','ct_hoa_dons.content')
        ->get();
        
        $cthd_product = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->join('hoa_dons', 'hoa_dons.id', '=', 'ct_hoa_dons.hoa_don_id')
        ->select('productts.id','productts.thumb','productts.name','productts.price_sale','ct_hoa_dons.SL','ct_hoa_dons.thanhtien', 'hoa_dons.tongtien' )
        ->get();
        $cthd_tongtien = DB::table('hoa_dons')
        ->where('hoa_dons.id', $hoadon->id)
        ->select('hoa_dons.tongtien' )
        ->get();

        $Size_user = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->select('ct_hoa_dons.size')
        ->first();
        $Mau_user = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->select('ct_hoa_dons.mau')
        ->first();

        return view('history.history_detail', [
            'icons'=>'<i class="fa fa-cart-plus" aria-hidden="true"></i>',
            'cthd' => $cthd,
            'ctproducts' => $cthd_product,
            'cttt' => $cthd_tongtien,
            'maus' => $Mau_user,
            'sizes' => $Size_user,
        ]);
    }

    public function dahuy(Request $request)
    {
        $capnhat=$request->input('trangthaihd4');
        $id=$request->input('idhoadonhuy');
        $laysp = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('productts.id','ct_hoa_dons.size','ct_hoa_dons.mau')
        ->get();
        $sl3 = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('ct_hoa_dons.SL','productts.id')
        ->get();
        $slend=0;
        foreach ($laysp as $laysps){
        $bienthe = DB::table('bien_thes')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->where('bien_thes.san_pham_id',$laysps->id)
        ->where('sizes.tensize',$laysps->size)
        ->where('maus.tenmau',$laysps->mau)
        ->get();

        foreach($bienthe as $bienthes) {
            foreach($sl3 as $sl){
                if($bienthes->san_pham_id==$sl->id)
                $slend=$bienthes->SL+=$sl->SL; 
            }
        }
        DB::table('bien_thes')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->where('san_pham_id',$laysps->id)
        ->where('sizes.tensize',$laysps->size)
        ->where('maus.tenmau',$laysps->mau)
        ->update(['SL'=>$slend]);
        }
        
        HoaDon::where('id',$id)
        ->update(['ds_trang_thai_id'=>$capnhat]);
        Session::flash('success', 'Cập nhật trạng thái thành công');
        return redirect('/history');
    }
    public function ud_dangxuly(Request $request)
    {
        $capnhat=$request->input('trangthai_dxl');
        $id=$request->input('idhoadon_dxl');
        $laysp = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('productts.id','ct_hoa_dons.size','ct_hoa_dons.mau')
        ->get();
        $sl_first = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('ct_hoa_dons.SL')
        ->get();

        foreach ($laysp as $laysps){
        $bienthe = DB::table('bien_thes')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->where('san_pham_id',$laysps->id)
        ->where('sizes.tensize',$laysps->size)
        ->where('maus.tenmau',$laysps->mau)
        ->get();
        }

        $slend=0;
        foreach($bienthe as $bienthes) {
            foreach($sl_first as $sl){
            $slend=$bienthes->SL-=$sl->SL; 
            }
        }

        DB::table('bien_thes')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->where('san_pham_id',$laysps->id)
        ->where('sizes.tensize',$laysps->size)
        ->where('maus.tenmau',$laysps->mau)
        ->update(['SL'=>$slend]);

        HoaDon::where('id',$id)
        ->update(['ds_trang_thai_id'=>$capnhat]);
        Session::flash('success', 'Cập nhật trạng thái thành công');
        return redirect('/history');
    }

    public function filterbydate(Request $request)
    {
     $data = $request->all();
     $from_date=$data['from_date'];
     $to_date=$data['to_date'];
     $get=HoaDon::whereBetween('thoigian', [$from_date, $to_date])
     ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
            ->groupByRaw('DATE(thoigian)')
            ->orderBy('thoigian', 'ASC')
            ->get();
     foreach($get as $key=> $val){
        $chart_data[] = array(
        'thoigian'=> $val->day,
        'tongtien'=>$val->tt
        );
        } 
         echo $data=json_encode($chart_data);        
    }

    public function dashboard_filter(Request $request)
    {
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            if($data['dashboard_value']=='7ngay'){
            $get = HoaDon::whereBetween('thoigian', [$sub7days, $now])
            ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
            ->groupByRaw('DATE(thoigian)')
            ->orderBy('thoigian', 'ASC')
            ->get();
            }elseif ($data['dashboard_value']=='thangtruoc'){
            $get = HoaDon::whereBetween('thoigian', [$dau_thangtruoc, $cuoi_thangtruoc])
            ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
            ->groupByRaw('DATE(thoigian)')
            ->orderBy('thoigian', 'ASC')
            ->get();
            }elseif($data['dashboard_value']=='thangnay'){
            $get = HoaDon::whereBetween('thoigian', [$dauthangnay, $now])
            ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
            ->groupByRaw('DATE(thoigian)')
            ->orderBy('thoigian', 'ASC')
            ->get();
            }else{
            $get =HoaDon::whereBetween('thoigian', [$sub365days, $now])
            ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
            ->groupByRaw('DATE(thoigian)')
            ->orderBy('thoigian', 'ASC')
            ->get();
             }
            
            foreach($get as $key=> $val){
                $chart_data[] = array(
                'thoigian'=> $val->day,
                'tongtien'=>$val->tt
                );
                } 
                echo $data=json_encode($chart_data);        
            }
    

            public function days_order(Request $request)
            {
                $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                
                $get=HoaDon::whereBetween('thoigian', [$sub30days, $now])
                // ->select('thoigian')
                ->selectRaw('sum(tongtien) as tt, DATE(thoigian) as day')
                ->groupByRaw('DATE(thoigian)')
                ->orderBy('thoigian', 'ASC')
                ->get();
                
                foreach($get as $key=> $val){
                    $chart_data[] = array(
                    'thoigian'=> $val->day,
                    'tongtien'=>$val->tt,
                    );
                 } 
                    echo $data=json_encode($chart_data);        
            }


            public function chart_sp(Request $request)
            {
                $get=CTHoaDon::select('product_id')
                ->selectRaw('sum(SL) as sumsl')
                ->groupBy('product_id')
                ->get();
                foreach($get as $key=> $val){
                    $nameproduct=Productt::where('id',$val->product_id)->select('name')->get();
                    foreach($nameproduct as $key=>$sp){
                    $chart_data[] = array(
                    'product_id'=> $sp->name,
                    'sumsl'=>$val->sumsl
                    );
                    }
                 }
                    echo $data=json_encode($chart_data);        
            }


            public function tonkho(Request $request)
            {
                // $get=Productt::all();
                $get=DB::table('bien_thes')
                ->join('productts','bien_thes.san_pham_id','=','productts.id')
                ->join('sizes','bien_thes.size_id','=','sizes.id')
                ->join('maus','bien_thes.mau_id','=','maus.id')
                ->select('productts.name','bien_thes.size_id','bien_thes.mau_id','bien_thes.SL')
                ->get();

                foreach($get as $key=> $val){
                    $chart_data[] = array(
                    'name'=> $val->name,
                    'SL'=>$val->SL,
                    'size'=> $val->size_id,
                    'mau'=> $val->mau_id,
                    );
                    }
                    echo $data=json_encode($chart_data);        
            }


            public function trangthai(Request $request)
            {
                $get=HoaDon::select('ds_trang_thai_id')
                ->selectRaw('count(id) as sl')
                ->groupBy('ds_trang_thai_id')
                ->get();
                foreach($get as $key=> $val){
                    $namett=DSTrangThai::where('id',$val->ds_trang_thai_id)->select('tenTT')->get();
                    foreach($namett as $key=>$tt){
                    $chart_data[] = array(
                    'tentt'=>$tt->tenTT,
                    'sl'=>$val->sl
                    );
                    }
                 }
                echo $data=json_encode($chart_data);        
            }


           


   

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHoaDonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHoaDonRequest $request, HoaDon $hoaDon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HoaDon $hoaDon)
    {
        //
    }
}
