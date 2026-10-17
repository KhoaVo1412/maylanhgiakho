<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\CTHoaDon;
use App\Models\Customer;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }
    public function __constructt(CartService $adress)
    {
        $this->cart = $adress;
    }

    public function index()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();

       
        return view('admin.carts.customer',[
            'icons'=>'<i class="fa fa-cart-plus" aria-hidden="true"></i>',
            'title' => 'Danh Sách Hóa Đơn',
            'customers'=>$this->cart->getCustomer(),
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function indexlog()
    {
        // $hd=HoaDon::orderByDesc('id')->paginate(10);

        $hd = DB::table('hoa_dons')
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra', 'hoa_dons.ds_trang_thai_id')
        ->orderByDesc('hoa_dons.id','desc')
        ->paginate(10);
        

        $sp=Productt::all()->count();
        $hd2=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.carts.customerlog',[
            'icons'=>'<i class="fa fa-cart-plus" aria-hidden="true"></i>',
            'title' => 'Danh Sách Hóa Đơn',
            'hoadons'=>$hd,
            'spss'=>$sp,
            'hds'=>$hd2,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function show(Customer $customer)
    {
        $adr_customers = DB::table('customers')
        ->where('customers.id', $customer->id)
        ->join('tinh_tps', 'customers.city', '=', 'tinh_tps.id')
        ->join('quan_huyens', 'customers.district', '=', 'quan_huyens.id')
        ->join('phuong_xas', 'customers.ward', '=', 'phuong_xas.id')
        ->select('tinh_tps.tenTP', 'quan_huyens.tenQH', 'phuong_xas.tenPX')
        ->get();

        $Size_customers = DB::table('carts')
        ->where('carts.customer_id', $customer->id)
        ->join('sizes', 'carts.size', '=', 'sizes.id')
        ->select('sizes.tensize')
        ->get();

        $Mau_customers = DB::table('carts')
        ->where('carts.customer_id', $customer->id)
        ->join('maus', 'carts.mau', '=', 'maus.id')
        ->select('maus.tenmau')
        ->get();

        $carts = $this->cart->getProductForCart($customer);
        $ctcart = DB::table('carts')
        ->where('carts.customer_id', $customer->id)
        ->join('pt_thanh_toans', 'carts.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'carts.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select('pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT')
        ->get();

        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.carts.detail', [
            'icons'=>'<i class="fa fa-cart-plus" aria-hidden="true"></i>',
            'title' => 'Chi Tiết Hóa Đơn > ' . $customer->name,
            'customer' => $customer,
            'ctcart' =>$ctcart,
            'carts' => $carts,
            'adr_customers' => $adr_customers,
            'S_customers' => $Size_customers,
            'M_customers' => $Mau_customers,
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function showlog(HoaDon $hoadon)
    {
        $cthd = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->select('ct_hoa_dons.name','ct_hoa_dons.phone','ct_hoa_dons.email','ct_hoa_dons.address','ct_hoa_dons.content')
        ->first();
        
        $cthd_product = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('productts.thumb','productts.name','productts.price_sale','ct_hoa_dons.SL','ct_hoa_dons.thanhtien','ct_hoa_dons.size','ct_hoa_dons.mau' )
        ->get();

        // $Size_user = DB::table('ct_hoa_dons')
        // ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        // ->select('ct_hoa_dons.size')
        // ->get();
        // dd($Size_user);

        // $Mau_user = DB::table('ct_hoa_dons')
        // ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        // ->select('ct_hoa_dons.mau')
        // ->get();

        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.carts.detaillog', [
            'icons'=>'<i class="fa fa-cart-plus" aria-hidden="true"></i>',
            'title' => 'Chi Tiết Hóa Đơn',
            'cthd' => $cthd,
            'ctproducts' => $cthd_product,
            // 'maus' => $Mau_user,
            // 'sizes' => $Size_user,
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
        ]);
    }

    public function danggiao(Request $request)
    {
        $capnhat=$request->input('trangthaihd');
        $id=$request->input('id');
        HoaDon::where('id',$id)
        ->update(['ds_trang_thai_id'=>$capnhat]);
        Session::flash('success', 'Cập nhật trạng thái thành công');
        return redirect('/admin/customerslog');
    }

    public function hoanthanh(Request $request)
    {
        $capnhat=$request->input('trangthaihd3');
        $id=$request->input('idhoanthanh');
        HoaDon::where('id',$id)
        ->update(['ds_trang_thai_id'=>$capnhat]);
        Session::flash('success', 'Cập nhật trạng thái thành công');
        return redirect('/admin/customerslog');
    }

    public function huydon(Request $request)
    {
        $capnhat=$request->input('trangthaihd4');
        $id=$request->input('hoadonhuy');
        $laysp = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('productts.id','ct_hoa_dons.size','ct_hoa_dons.mau')
        ->get();

        $sl3 = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $id)
        ->join('productts', 'productts.id', '=', 'ct_hoa_dons.product_id')
        ->select('ct_hoa_dons.SL','productts.id','ct_hoa_dons.size','ct_hoa_dons.mau')
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
                if($bienthes->san_pham_id==$sl->id && $bienthes->tensize==$sl->size && $bienthes->tenmau==$sl->mau)
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
        return redirect('/admin/customerslog');
    }

    public function convert_html_pdf(HoaDon $hoadon){

        $pdf=App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print($hoadon));
        return $pdf->stream();

    }

    public function print($hoadon)
    {   
        $users = DB::table('hoa_dons')
        ->where('hoa_dons.id', $hoadon->id)
        ->join('ct_hoa_dons', 'hoa_dons.id', '=', 'ct_hoa_dons.hoa_don_id')
        ->select('ct_hoa_dons.name','ct_hoa_dons.phone','ct_hoa_dons.email','ct_hoa_dons.address','ct_hoa_dons.content')
        ->first();
        $hds=DB::table('hoa_dons')
        ->where('hoa_dons.id', $hoadon->id)
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select('hoa_dons.id','hoa_dons.thoigian','hoa_dons.tongtien','pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.tiengg','hoa_dons.tientra')
        ->get();
        $dls = DB::table('ct_hoa_dons')
        ->where('ct_hoa_dons.hoa_don_id', $hoadon->id)
        ->join('productts', 'ct_hoa_dons.product_id', '=', 'productts.id')
        ->select('ct_hoa_dons.size','ct_hoa_dons.mau','ct_hoa_dons.SL','ct_hoa_dons.gia','ct_hoa_dons.thanhtien','productts.name')
        ->get();
        $print='';
        $print.='

        <style>
            body{
                font-family: DeJavu Sans
            }
           
        </style>
                <h1 style="text-align:center">Shop ARB</h1>
                <h3 style="text-align:center">Thông Tin Hóa Đơn Đặt Hàng</h3>';
                foreach($hds as $key=>$hd){
                    $print.='   <b>Mã Hóa Đơn:  </b><span>' .$hd->id .'</span></br>
                    
                    ';
                }

        $print.='

                <b>Tên Người Nhận:  </b><span>' .$users->name .'</span></br>
                <b>Số Điện Thoại Người Nhận:  </b><span>' .$users->phone .'</span></br>
                <b>Email Người Nhận:  </b><span>' .$users->email .'</span></br>
                <b>Địa Chỉ Người Nhận:  </b><span>' .$users->address .'</span></br>
                <b>Ghi Chú:  </b><span>' .$users->content .'</span></br>
        ';

        foreach($hds as $key=>$hd){
        $print.='
        <b>Thời Gian Đặt Hàng:  </b><span>' .$hd->thoigian .'</span></br>
        <b>Phương Thức Thanh Toán:  </b><span>' .$hd->tenthanhtoan .'</span></br>
        ';
        }
        $print.='
        <table class="table" style="border: 1px solid #000000;width: 700px">
        <thead>
            <tr>
                <th style="margin-right: 500px">Tên Sản Phẩm</th>
                <th>Size</th>
                <th>Màu</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($dls as $key =>$dl){
            $print.='
                <tr>
                    <td style="text-align:center">'.$dl->name.'</td>
                    <td style="text-align:center">'.$dl->size.'</td>
                    <td style="text-align:center">'.$dl->mau.'</td>
                    <td style="text-align:center">'.$dl->SL.'</td>
                    <td style="text-align:center">'.$dl->gia.'</td>
                    <td style="text-align:center">'.$dl->thanhtien.'</td>
                </tr>';
                    }
                   
        $print.='
        </tbody>
        </table>
        ';
        $print.='
          <table style="border: 1px solid #000000; margin-top: 20px">';
          foreach($hds as $key=>$hd){
            $print.='
            <tr></tr>
            <tr>
                td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>';
                $print.=' <td><b>Tổng Tiền:</b>'.$hd->tongtien.'</td>
            </tr>

            <tr>
                td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>';
                $print.=' <td><b>Tiền Giảm:</b>'.$hd->tiengg.'</td>
            </tr>

            <tr>
                td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>';
                $print.=' <td><b>Tiền Phải Trả:</b>'.$hd->tientra.'</td>            </tr>
            ';
        }
        $print.='</table>               
        ';

        $print.='
        
        <table class="table" style="margin-top: 20px">>
        <thead>
            <tr>
                <td style="width: 200px; padding-top: 50px"></td>
                
            </tr>

            <tr>
                <td style="width: 200px; padding-top: 10px">Người nhận</td>
                <td style="width: 800px; text-align: center; padding-top: 10px">Người lập hóa đơn</td>
            </tr>
            <tr>
            <td style="width: 200px; padding-top: 10px"></td>
            <td style="width: 800px; text-align: center; padding-top: 10px; font-size: 12px">(ký và ghi rõ họ tên)</td>
            </tr>
        </table>
        ';
        return $print;
    }
    
    public function dangxuly_admin()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $hd = DB::table('hoa_dons')
        ->where('ds_trang_thai_id','=',1)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra')
        ->orderByDesc('hoa_dons.id','desc')
        ->get();
        return view('admin.carts.bill_processing',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'hoadons' => $hd,
        ]);
    }
    
    public function danggiao_admin()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $hd = DB::table('hoa_dons')
        ->where('ds_trang_thai_id','=',2)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra')
        ->orderByDesc('hoa_dons.id','desc')
        ->get();
        return view('admin.carts.bill_delivering',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'hoadons' => $hd,
        ]);
    }

    public function hoanthanh_admin()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $hd = DB::table('hoa_dons')
        ->where('ds_trang_thai_id','=',3)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra')
        ->orderByDesc('hoa_dons.id','desc')
        ->get();
        return view('admin.carts.bill_finish',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'hoadons' => $hd,
        ]);
    }

    public function dahuy_admin()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $hd = DB::table('hoa_dons')
        ->where('ds_trang_thai_id','=',4)
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra')
        ->orderByDesc('hoa_dons.id','desc')
        ->get();
        return view('admin.carts.bill_cancel',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'hoadons' => $hd,
        ]);
    }

    
}
