<?php


namespace App\Http\Services\Productt;


use App\Models\Menu;
use App\Models\Productt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProducttAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return true;
    }

    public function insert($request)
    {

        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;
        
        try {
            $request->except('_token');
            Productt::create($request->all());

            Session::flash('success', 'Add product success');
        } catch (\Exception $err) {
            Session::flash('error', 'Add product fail');
            Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }

    public function get()
    {
        return Productt::with('menu')
        //15
            ->orderByDesc('id')->paginate(10);
    }

    public function update($request, $productt)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) return false;

        try {
            $productt->fill($request->input());
            $productt->save();
            Session::flash('success', 'Update success');
        } catch (\Exception $err) {
            Session::flash('error', 'Error plase again !');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $product = Productt::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}

