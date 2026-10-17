<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CartService;
use App\Http\View\Composers\CartComposer;
use App\Models\BienThe;
use App\Models\Coupon;
use App\Models\PhuongXa;
use App\Models\Productt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\TinhTP;
use App\Models\QuanHuyen;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\URL;


use Carbon\Carbon;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        
        $qty =(int)$request->input('num_product');
        $result = $this->cartService->create($request);
        // $size_id =(int)$request->input('size_id');
        // $tensize=Size::where('id',$size_id)->get();
        $product_id =(int)$request->input('product_id');
        $productts = Productt::select('id', 'name', 'price', 'price_sale', 'thumb')
        ->where('id', $product_id)
        ->get();
        $slctsp=BienThe::where('san_pham_id', $product_id)
        // ->where('size_id',$size_id)
        ->select('SL')
        ->get();
        foreach($slctsp as $sl){
            $slton=$sl->SL;
        }

        if ($qty <= 0||$qty>$slton) {
            Session::forget('carts');
            return redirect()->back()->with('error','Vui lòng kiểm tra lại thông tin');
        }
        else{
            foreach($productts as $tam){
                $name=$tam->name;
                if($tam->price_sale == null){
                $price=$tam->price;
                $thumb=$tam->thumb;
                }else{
                    $price=$tam->price_sale;
                    $thumb=$tam->thumb;
                }
            }
            // foreach($tensize as $tam){
            //     $laytensize=$tam->tensize;
            // }

            $data['id'] = $product_id;
            $data['qty'] = $qty;
            // $data['options']['sizes'] = $laytensize;
            $data['name'] = $name;
            $data['price'] = $price;
            $data['weight'] = '170';
            $data['options']['image'] = $thumb;
            Cart::add($data);
        }

        if($result === false)
        {
            return redirect()->back();
        }
        return redirect('/carts');
    }

    public function show()
    {
        $prod = TinhTP::all();
        $productts = $this->cartService->getProduct();
        $cartContent = Cart::content();
        $coupon = Session::get('coupon');

        return view('carts.list', [
            'title' => 'Giỏ hàng của bạn - Máy Lạnh Giá Kho',
            'productts' => $productts,
            'cartContent' => $cartContent,
            'carts' => Session::get('carts'),
            'coupon' => $coupon,
            'prod' => $prod
        ]);
    }

    public function vnpay(Request $request)
    {
        $this->cartService->createvnpay($request);
        return redirect('/carts');
    }
    public function thanhcong(Request $request)
    {
        Cart::destroy();
        Session::forget('carts');
        Session::forget('coupon');
        Session::flash('success', 'Bạn đã đặt hàng thành công.');
        return redirect('/carts');
    }
    public function remove($id = 0)
    {
        $this->cartService->remove($id);
        return redirect('/carts');
    }

    public function delete_to_cart($rowId){
        Cart::update($rowId, 0);
        if(Cart::Count()==0){
            Session::forget('carts');
            Session::forget('coupon');
        }


        return redirect('/carts');
    }

    public function addCart(Request $request)
    {
        $this->cartService->addCart($request);
        return redirect()->back();
    }



    public function update(Request $request)
    {

        $this->cartService->update($request);
        return redirect('/carts');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->input('rowId_cart');
        $qty = $request->input('num_product');
            foreach ($rowId as $row){
                Cart::update($row,$qty[$row]);
                
            }
        
        return redirect('/carts');
    }
    public function findmau(Request $request){

        $data= DB::table('bien_thes')
        ->where('san_pham_id', $request->idpro)
        ->where('size_id', $request->id)
        ->join('maus', 'maus.id', '=', 'bien_thes.mau_id')
        ->select('maus.id', 'maus.tenmau')
        ->get();
        return response()->json($data);
	}

    public function findsize(Request $request){

        $data= DB::table('bien_thes')
        -> where('san_pham_id', $request->idpro)
        ->where('mau_id', $request->id)
        ->join('sizes', 'sizes.id', '=', 'bien_thes.size_id')
        ->select('sizes.id', 'sizes.tensize')
        ->get();
        return response()->json($data);
	}

    public function findQuanHuyen(Request $request){

        $data=QuanHuyen::where('tinh_tp_id', $request->id)->get();
        return response()->json($data);
	}

    public function findPhuongXa(Request $request){

        $data=PhuongXa::where('quan_huyen_id', $request->id)->get();
        return response()->json($data);
	}

    public function giamgia(Request $request){
        $data = $request->all();
        $magiamgia=$data['coupon'];
        $coupon = Coupon::where('magg',$data['coupon'])->first();
        if($coupon){
            if($coupon->slgg<=0){
                return redirect()->back()->with('error', 'Mã giảm gia đã hết!!!');
            }
                    $count_coupon = $coupon->count();
                    if($count_coupon>0){
                        $coupon_session = Session::get('coupon');
                        if($coupon_session == true){
                            $is_avaiable = 0;
                            if($is_avaiable == 0){
                                $cou[] = array(
                                'magg'>$coupon->magg,
                                'tngg'=> $coupon->tngg,
                                'sotiengg' => $coupon->sotiengg,
                                );
                                Session::put('coupon',$cou);
                            }
                        }
                            else{
                                $cou[] = array(
                                    'magg'=>$coupon->magg,
                                    'tngg'=> $coupon->tngg,
                                    'sotiengg' => $coupon->sotiengg,
                            );
                        Session::put('coupon',$cou);
                    }
                        Session::save();
                        //         $slgiamgia=0;
                        //         $slgg=Coupon::where('magg',$data['coupon'])->select('slgg')->get();
                        //         foreach($slgg as $sl){
                        //         $slgiamgia=$sl->slgg-1;
                        //         }
                        // Coupon::where('magg',$data['coupon'])->update(['slgg'=>$slgiamgia]);
                        return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
                    }
        }else{
            return redirect()->back()->with('error', 'Mã giảm giá không chính xác!!!');
        }
    }
}
