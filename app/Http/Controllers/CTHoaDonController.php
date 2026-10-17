<?php

namespace App\Http\Controllers;

use App\Models\CTHoaDon;
// use App\Http\Requests\StoreCTHoaDonRequest;
// use App\Http\Requests\UpdateCTHoaDonRequest;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CTHoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user_id = Auth::user()->id;
        $layhd = DB::table('hoa_dons')
        ->where('user_id', $user_id)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien')
        ->get();
        // $hoaDon_id = HoaDon::select('id')->where('user_id', $user_id)->get();
        // $data = [];
        // foreach($hoaDon_id as $hoadonsp){
        //     $data [] = CTHoaDon::select('id', 'name')
        //     ->where('hoa_don_id', $hoadonsp->id)->get();
        // }
        // $htr_s = $data;
        // $hoaDon_id = DB::table('hoa_dons')
        // ->where('user_id', $user_id)
        // ->join('ct_hoa_dons', 'hoa_dons.id', '=', 'ct_hoa_dons.hoa_don_id')
        // ->join('productts','ct_hoa_dons.product_id', '=', 'productts.id')
        // ->join('sizes', 'ct_hoa_dons.size', '=', 'sizes.id')
        // ->join('maus', 'ct_hoa_dons.mau', '=', 'maus.id')
        // ->select('productts.name', 'productts.price','productts.thumb','ct_hoa_dons.SL'
        //     ,'ct_hoa_dons.thanhtien', 'sizes.tensize', 'maus.tenmau', 'hoa_dons.tongtien'
        //     ,'hoa_dons.id')
        // ->get();
        return view('history.history_order',[
            'hoadons' => $layhd,
        ]);
    }

    

   


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreCTHoaDonRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(CTHoaDon $cTHoaDon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CTHoaDon $cTHoaDon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateCTHoaDonRequest $request, CTHoaDon $cTHoaDon)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CTHoaDon $cTHoaDon)
    {
        //
    }
}
