<?php

namespace App\Http\Services;

use App\Models\BienThe;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CTHoaDon;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DSTrangThai;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\PTThanhToan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Support\Facades\Auth;
use ZipStream\Bigint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class CartService
{
    public function create($request)
    {
        $qty =(int)$request->input('num_product');
        $product_id =(int)$request->input('product_id');
  
        if($qty <= 0 || $product_id <= 0)
        {
            Session::flash('error', 'The quantity is incorrect.');
            return false;
        }
        $carts = Session::get('carts');
            if(is_null($carts)){
                Session::put('carts', [
                    $product_id => $qty,
                ]);
                return true;    
            } 
        $carts[$product_id] = $qty;
        Session::put('carts', $carts);
        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');
        if(is_null($carts)) return [];
        $productId = array_keys($carts);
        return Productt::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }
   
    public function update($request)
    {

        Session::put('carts', $request->input('num_product'));
        return true;
        
    }

    public function remove($id)
    {
        $carts = Session::get('carts');
        unset($carts[$id]);

        Session::put('carts', $carts);
        return true;
    }
    
    public function addCart($request)
    {
        try {
            DB::beginTransaction();
            if(Auth::check()){
                $hd = HoaDon::create([
                    'user_id' => Auth::user()->id,
                    'pt_thanh_toan_id'=>$request->input('pttt'),
                    'ds_trang_thai_id'=>$request->input('dstt'),
                    'thoigian'=>Carbon::now('Asia/Ho_Chi_Minh'),
                    'tongtien' => (int)$request->input('tongtien'),
                    'tiengg' => (int)$request->input('tiengg'),
                    'tientra' => (int)$request->input('tientra'),
                ]);
                $content = FacadesCart::content();
                $data=[];
                foreach($content as $v_content){
                    $data[] = [
                        'name' => $request->input('name'),
                        'phone' => $request->input('phone'),
                        'address' => $request->input('address'),
                        'email' => $request->input('email'),
                        'content' => $request->input('content'),
                        'hoa_don_id' => $hd->id,
                        'product_id'=>$v_content->id,
                        // 'size'=>$v_content->options->sizes,
                        'SL'=>$v_content->qty,
                        'gia'=>(int)$v_content->price,
                        'thanhtien'=>(int)$request->input('thanhtien')
                    ];
                    $size_cart=$v_content->options->sizes;
                    // $this->addsl($v_content->id,$size_cart,$v_content->qty);
                    $this->addsl($v_content->id,$v_content->qty);
                    
                }
                if(Session::get('coupon')){
                    foreach(Session::get('coupon') as $key=>$ma){
                        $lay_ma = $ma['magg'];
                    }
                    //dd( $lay_ma);
                    $slgiamgia = 0;
                    $slgg = Coupon::where('magg',$lay_ma)->select('slgg')->get();
                    //dd($slgg);
                    foreach($slgg as $sl){
                    $slgiamgia=$sl->slgg-1;
                    }
                    Coupon::where('magg',$lay_ma)->update(['slgg'=>$slgiamgia]);
                }
                CTHoaDon::insert($data);
                $tt=$request->input('pttt');
                $tentrangthai=PTThanhToan::where('id',$tt)->get();
                foreach($tentrangthai as $ten){
                    $tentt=$ten->tenthanhtoan;
                }      
                         
                $email=$request->input('email');
                $name=$request->input('name');
                $hdid=$hd->id;
                $hdtg=$hd->thoigian;
                $hdpttt=$tentt;
                $hdtongtien=(int)$request->input('tongtien');
                $item=FacadesCart::content();
                Mail::send('mail.ordersuccess',[
                    'name'=> $name,
                    'order'=> $hdid,
                    'tg'=> $hdtg,
                    'pttt'=> $hdpttt,
                    'tongtien'=> $hdtongtien,
                    'items'=> $item,

                ], function ($mail) use($email,$name) {
                    $mail->from('congthuong01112002@gmail.com');
                    $mail->to($email,$name);
                    $mail->subject('Email odered');
                });

            }else{
                $customer = Customer::create([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'district' => $request->input('district'),
                    'ward' => $request->input('ward'),
                    'email' => $request->input('email'),
                    'content' => $request->input('content'),
                ]);
                $pttt = $request->input('pttt');
                $dstt = $request->input('dstt');
                $content = FacadesCart::content();
                $data=[];
                foreach($content as $v_content){
                    $size_cart=$v_content->options->sizes;
                    // $this->addsl($v_content->id,$size_cart,$v_content->qty);
                    // $this->infoProductCart($customer->id, $size_cart,$pttt,$dstt);
                    $this->addsl($v_content->id,$v_content->qty);
                    $this->infoProductCart($customer->id,$pttt,$dstt);
                    
                }

                $tentrangthai=PTThanhToan::where('id',$pttt)->get();
                foreach($tentrangthai as $ten){
                    $tentt=$ten->tenthanhtoan;
                } 
                $email=$request->input('email');
                $name=$request->input('name');
                $hdtg=$customer->created_at;
                $hdpttt=$tentt;
                // $hdtongtien=$dstt;
                $item=FacadesCart::content();
                Mail::send('mail.ordervl',[
                    'name'=> $name,
                    'tg'=> $hdtg,
                    'pttt'=> $hdpttt,
                    // 'tongtien'=> $hdtongtien,
                    'items'=> $item,

                ], function ($mail) use($email,$name) {
                    $mail->from('congthuong01112002@gmail.com');
                    $mail->to($email,$name);
                    $mail->subject('Email odered');
                });
                FacadesCart::destroy();
            }

            
            DB::commit();
            Session::flash('success', 'Đặt Hàng Thành Công.');
           

            #Queue
            // SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
           
            FacadesCart::destroy();
            Session::forget('carts');
            Session::forget('coupon');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Thất Bại.');
            return false;
        }

        return true;
    }

    public function createvnpay(Request $request)
    {
        try{
        DB::beginTransaction();
            if(Auth::check()){
                $hd = HoaDon::create([
                    'user_id' => Auth::user()->id,
                    'pt_thanh_toan_id'=>$request->input('ptttvnpay'),
                    'ds_trang_thai_id'=>$request->input('dsttvnpay'),
                    'thoigian'=>Carbon::now('Asia/Ho_Chi_Minh'),
                    'tongtien' => (int)$request->input('tongtienvnpay'),
                    'tiengg' => (int)$request->input('tiengg'),
                    'tientra' => (int)$request->input('tientra'),
                ]);

                $content = FacadesCart::content();
                $data=[];
                foreach($content as $v_content){
                    $data[] = [
                        'name' => $request->input('namevnpay'),
                        'phone' => $request->input('phonevnpay'),
                        'address' => $request->input('addressvnpay'),
                        'email' => $request->input('emailvnpay'),
                        'content' => $request->input('contentvnpay'),
                        'hoa_don_id' => $hd->id,
                        'product_id'=>$v_content->id,
                        'size'=>$v_content->options->sizes,
                        'SL'=>$v_content->qty,
                        'gia'=>(int)$v_content->price,
                        'thanhtien'=>(int)$request->input('thanhtienvnpay')
                    ];
                    //  $size_cart=$v_content->options->sizes;
                    // $this->addsl($v_content->id,$size_cart,$v_content->qty);
                    $this->addsl($v_content->id,$v_content->qty);
                    
                    
                }
                if(Session::get('coupon')){
                    foreach(Session::get('coupon') as $key=>$ma){
                        $lay_ma = $ma['magg'];
                    }
                    //dd( $lay_ma);
                    $slgiamgia = 0;
                    $slgg = Coupon::where('magg',$lay_ma)->select('slgg')->get();
                    //dd($slgg);
                    foreach($slgg as $sl){
                    $slgiamgia=$sl->slgg-1;
                    }
                    Coupon::where('magg',$lay_ma)->update(['slgg'=>$slgiamgia]);
                }
                CTHoaDon::insert($data);
            }

            $tt=$request->input('ptttvnpay');
                $tentrangthai=PTThanhToan::where('id',$tt)->get();
                foreach($tentrangthai as $ten){
                    $tentt=$ten->tenthanhtoan;
                } 
            $email=$request->input('emailvnpay');
            $name=$request->input('namevnpay');
            $hdid=$hd->id;
            $hdtg=$hd->thoigian;
            $hdpttt=$tentt;
            $hdtongtien=$hd->tongtien;
            $item=FacadesCart::content();
            Mail::send('mail.ordersuccess',[
                'name'=> $name,
                'order'=> $hdid,
                'tg'=> $hdtg,
                'pttt'=> $hdpttt,
                'tongtien'=> $hdtongtien,
                'items'=> $item,

            ], function ($mail) use($email,$name) {
                $mail->from('congthuong01112002@gmail.com');
                $mail->to($email,$name);
                $mail->subject('Email odered');
            });
            DB::commit();
            

            #Queue
            // SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
        }catch(\Exception $err){
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Thất Bại.');
            return false;
        }

        // FacadesCart::destroy();
        // Session::forget('carts');
        return $this->vnpay($hd->id,$hd->tongtien);

           
    }
    public function vnpay($id,$tongtien){
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://localhost:8000/thanhcong";
            $vnp_TmnCode = "70EQN4UN";//Mã website tại VNPAY 
            $vnp_HashSecret = "WQUTQTGBQZQKMQQFONPXCGKOSANAINQH"; //Chuỗi bí mật
            $vnp_TxnRef = $id; //$_POST['order_id'] $_POST['order_desc'] $_POST['order_type'] $_POST['amount'] $_POST['language']  $_POST['bank_code']Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo ='Thanh Toán Đơn Hàng';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $tongtien * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode ='NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $_POST['txtexpire'];
            //Billing
            // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
            // $vnp_Bill_Email = $_POST['txt_billing_email'];
            // $fullName = trim($_POST['txt_billing_fullname']);
            // if (isset($fullName) && trim($fullName) != '') {
            //     $name = explode(' ', $fullName);
            //     $vnp_Bill_FirstName = array_shift($name);
            //     $vnp_Bill_LastName = array_pop($name);
            // }
            // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
            // $vnp_Bill_City=$_POST['txt_bill_city'];
            // $vnp_Bill_Country=$_POST['txt_bill_country'];
            // $vnp_Bill_State=$_POST['txt_bill_state'];
            // // Invoice
            // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
            // $vnp_Inv_Email=$_POST['txt_inv_email'];
            // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
            // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
            // $vnp_Inv_Company=$_POST['txt_inv_company'];
            // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
            // $vnp_Inv_Type=$_POST['cbo_inv_type'];
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                // "vnp_ExpireDate"=>$vnp_ExpireDate,
                // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
                // "vnp_Bill_Email"=>$vnp_Bill_Email,
                // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
                // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
                // "vnp_Bill_Address"=>$vnp_Bill_Address,
                // "vnp_Bill_City"=>$vnp_Bill_City,
                // "vnp_Bill_Country"=>$vnp_Bill_Country,
                // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
                // "vnp_Inv_Email"=>$vnp_Inv_Email,
                // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
                // "vnp_Inv_Address"=>$vnp_Inv_Address,
                // "vnp_Inv_Company"=>$vnp_Inv_Company,
                // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
                // "vnp_Inv_Type"=>$vnp_Inv_Type
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
                if (isset($_POST['redirect'])) {
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    echo json_encode($returnData);
                }
    }


    // public function addsl($sp,$size,$sl3){
    
    public function addsl($sp,$sl3){
        $bienthe = DB::table('bien_thes')
        // ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->where('san_pham_id',$sp)
        // ->where('sizes.tensize',$size)
        ->get();

        $slend=0;
        foreach($bienthe as $bienthes) {
            $slend=$bienthes->SL-=$sl3; 
        }

        DB::table('bien_thes')
        // ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->where('san_pham_id',$sp)
        // ->where('sizes.tensize',$size)
        ->update(['SL'=>$slend]);
                    
        $slsp=Productt::Where('id',$sp)->get();
        $slspend=0;
        foreach($slsp as $sllsp) {
        $slspend=$sllsp->SL-=$sl3; 
        }
                 Productt::where('id',$sp)
                ->update(['SL'=>$slspend]); 
          
        return true;
    }

    // protected function infoProductCart($customer_id, $size ,$pttt,$dstt)
    
    protected function infoProductCart($customer_id ,$pttt,$dstt)
    {

        $content = FacadesCart::content();
            $data=[];

            foreach($content as $v_content){
                $data[]=[
                    'customer_id'=>$customer_id,
                    'product_id'=>$v_content->id,
                    'pty'=>$v_content->qty,
                    'price'=>$v_content->price,
                    // 'size'=>$size,
                    'pt_thanh_toan_id'=>$pttt,
                    'ds_trang_thai_id'=>$dstt,
                ];
            }
        return Cart::insert($data);
    }

    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(10);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query){
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
}
