<?php


namespace App\Http\Services\Bienthe;


use App\Models\BienThe;
use App\Models\Mau;
use App\Models\Productt;
use App\Models\Size;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BTService
{
    public function getSP()
    {
        return Productt::where('active', 1)->orderBy('id','desc')->get();
    } 
    public function getSize()
    {
        return Size::where('active', 1)->get();
    }
    public function getMau()
    {
        return Mau::where('active', 1)->get();
    }

    

    public function insert($request)
    {

      
        try {
            $request->except('_token');
            $sl= $request->SL;

            $size= $request->size_id;
            $mau= $request->mau_id;
            $sp= $request->san_pham_id;
            $kiemtrabt=BienThe::all();
            
            foreach ($kiemtrabt as $kiemtra){
                if($kiemtra->san_pham_id == $sp){
                    if( $kiemtra->size_id == $size){
                        if($kiemtra->mau_id == $mau){
                            $slupdate=$kiemtra->SL+$sl;
                            BienThe::where('san_pham_id',$sp)
                            ->where('mau_id',$mau)
                            ->where('size_id',$size)
                            ->update(['SL'=>$slupdate]);
                            Session::flash('success', 'Đã cập nhật lại số lượng vì sản phẩm đã có');
                            return true;

                        }
                    }
                }
            }
            
            BienThe::create($request->all());
            $slsp=Productt::where('id', $sp)->select('SL')->get();
            foreach ($slsp as $slsanp){
                $slproduct=$slsanp->SL+=$sl;
            }
            Productt::where('id', $sp)->update(['SL'=>$slproduct]);
            Session::flash('success', 'Thêm Chi Tiết Thành Công');
        } catch (\Exception $err) {
            Session::flash('error', 'Add CTSP fail');
            Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }

    

    public function update($request, $ctsp)
    {
        try {
            $ctsp->fill($request->input());
            $ctsp->save();
            Session::flash('success', 'Update success');
        } catch (\Exception $err) {
            Session::flash('error', 'Error plase again !');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        $bt = DB::table('bien_thes')
        ->join('productts', 'bien_thes.san_pham_id', '=', 'productts.id')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->select('productts.name', 'sizes.tensize', 'maus.tenmau','bien_thes.id','bien_thes.SL')
        ->paginate(10);
        return $bt;
    }

    public function delete($request)
    {
        $ctsp = BienThe::where('id', $request->input('id'))->first();
        if ($ctsp) {
            $ctsp->delete();
            return true;
        }

        return false;
    }
}

