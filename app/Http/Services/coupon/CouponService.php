<?php

namespace App\Http\Services\coupon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CouponService
{
    public function insert($request)
    {
        try{
            $request->except('_token');
            Coupon::create($request->input());
            Session::flash('success', 'Thêm Giảm Giá Thành Công.');
        }catch(\Exception $err){
            Session::flash('error', 'Thêm Giảm Giá Thất Bại.');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }
    public function get()
    {
        return Coupon::orderByDesc('id')->paginate(15);
    }

    public function update($request, $coupon)
    {
        try {
            $coupon->fill($request->input());
            $coupon->save();
            Session::flash('success', 'Update success');
        } catch (\Exception $err) {
            Session::flash('success', 'Update fail.');
            Log::info($err->getMessage());
            
            return false;
        }

        return true;
        
    }
    public function destroy($request)
    {
        $coupon = Coupon::where('id', $request->input('id'))->first();
        if ($coupon) {
            $coupon->delete();
            return true;
        }
        return false;
    }

    
    public function show()
    {
        return Coupon::where('active', 1)->orderByDesc('sort_by')->get();
    }
}