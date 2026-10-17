<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers;
use App\Models\BienThe;
use App\Models\Cart;
use App\Models\CTHoaDon;
use App\Models\Customer;
use App\Models\HoaDon;
use App\Models\Productt;
use Gloudemans\Shoppingcart\Facades;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnlineCheckoutController extends Controller
{


    public function create(Request $request)
    {
        try{
        DB::beginTransaction();
            if(Auth::check()){
                $hd = HoaDon::create([
                    'user_id' => Auth::user()->id,
                    'tongtien' => (int)$request->input('tongtienvnpay'),
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
                        'size'=>(int)$request->input('sizevnpay'),
                        'mau'=>(int)$request->input('mauvnpay'),
                        'SL'=>$v_content->qty,
                        'gia'=>(int)$v_content->price,
                        'thanhtien'=>(int)$request->input('thanhtienvnpay')
                    ];
                    $size_cart=(int)$request->input('sizevnpay');
                    $mau_cart=(int)$request->input('mauvnpay');
                    $this->addsl($v_content->id,$size_cart,$mau_cart,$v_content->qty);
                    
                }
                CTHoaDon::insert($data);
            }else{
                $customer = Customer::create([
                    'name' => $request->input('namevnpay'),
                    'phone' => $request->input('phonevnpay'),
                    'address' => $request->input('addressvnpay'),
                    'city' => $request->input('city'),
                    'district' => $request->input('district'),
                    'ward' => $request->input('ward'),
                    'email' => $request->input('emailvnpay'),
                    'content' => $request->input('contentvnpay'),
                ]);
                $size_ctm = $request->input('sizessss');
                $mau_ctm = $request->input('maussss');
                $this->infoProductCart($customer->id, $size_ctm, $mau_ctm);
                FacadesCart::destroy();
            }

            DB::commit();
           
            Session::flash('success', 'Orders success.');
            #Queue
            // SendMail::dispatch($request->input('email'))->delay(now()->addSeconds(2));
        }catch(\Exception $err){
            DB::rollBack();
            Session::flash('error', 'Orders fail.');
            return false;
        }
        return $this->vnpay();

           
    }
    public function vnpay(){

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://localhost:8000/history";
            FacadesCart::destroy();
            Session::forget('carts');
            $vnp_TmnCode = "70EQN4UN";//Mã website tại VNPAY 
            $vnp_HashSecret = "WQUTQTGBQZQKMQQFONPXCGKOSANAINQH"; //Chuỗi bí mật
            $vnp_TxnRef = 'HD'.time(); //$_POST['order_id'] $_POST['order_desc'] $_POST['order_type'] $_POST['amount'] $_POST['language']  $_POST['bank_code']Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo ='Thanh Toan Don Hang Test';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = 20000 * 100;
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

    public function addsl($sp,$size,$mau,$sl3){
        $sl=BienThe::Where('san_pham_id',$sp)
        ->where('size_id',$size)
        ->where('mau_id',$mau)
        ->get();
        $slend=0;
        
        foreach($sl as $sll) {
            $slend=$sll->SL-=$sl3; 
        }
                    BienThe::where('san_pham_id',$sp)
                    ->where('size_id',$size)
                    ->where('mau_id',$mau)
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

    protected function infoProductCart($customer_id, $size ,$mau)
    {

        $content = Cart::content();
            $data=[];

            foreach($content as $v_content){
                $data[]=[
                    'customer_id'=>$customer_id,
                    'product_id'=>$v_content->id,
                    'pty'=>$v_content->qty,
                    'price'=>$v_content->price,
                    'size'=>$size,
                    'mau'=>$mau,
                ];
            }
        return Cart::insert($data);
    }

   public function execPostRequest($url, $data)
    {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

    public function momo(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua  atm MoMo";
        $amount = "10000";
        $orderId = time() ."";
        $redirectUrl = "localhost:8000";
        $ipnUrl = "localhost:8000";
        $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there
           return redirect()->to($jsonResult['payUrl']);

    }

}

