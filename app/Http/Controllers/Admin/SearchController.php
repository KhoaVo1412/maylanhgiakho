<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\HoaDon;
use App\Models\Mau;
use App\Models\Menu;
use App\Models\Productt;
use App\Models\Size;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search_category(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_menu = Menu::where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.menu.list',[
            'title'=>'Danh Sách Loại Sản Phẩm',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'menus'=>$search_menu,
        ]);
    }

    public function search_product(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_prd = Productt::where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.productt.list',[
            'title'=>'Danh Sách Sản Phẩm',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'productts'=>$search_prd,
        ])->with('i',(request()->input('page',1)-1)*5);
    }
    public function search_color(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_color = Mau::where('tenmau','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.mau.list',[
            'title'=>'Danh Sách Màu',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'maus'=>$search_color,
        ]);
    }
    public function search_size(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_size = Size::where('tensize','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.size.list',[
            'title'=>'Danh Sách Size',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'sizes'=>$search_size,
        ]);
    }

    public function search_slider(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_slider = Slider::where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.slider.list',[
            'title'=>'Danh Sách Sliders',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'sliders'=>$search_slider,
        ]);
    }
    public function search_discount(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_slider = Coupon::where('tengg','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.giamgia.list',[
            'title'=>'Danh Sách Mã Giảm Giá',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'sizes'=>$search_slider,
        ]);
    }
    public function search_bill(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_bill = DB::table('hoa_dons')
        ->join('users', 'hoa_dons.user_id', '=', 'users.id')
        ->join('pt_thanh_toans', 'hoa_dons.pt_thanh_toan_id', '=', 'pt_thanh_toans.id')
        ->join('ds_trang_thais', 'hoa_dons.ds_trang_thai_id', '=', 'ds_trang_thais.id')
        ->select( 'hoa_dons.id','users.name','users.phone','users.email', 'pt_thanh_toans.tenthanhtoan','ds_trang_thais.tenTT','hoa_dons.thoigian','hoa_dons.tongtien','hoa_dons.tiengg','hoa_dons.tientra')
        ->orderByDesc('hoa_dons.id')
        ->where('users.name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.carts.customerlog',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'hoadons'=>$search_bill,
        ]);
    }
    public function search_user(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_user = User::where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.manager_user.list_customer',[
            'title'=>'Danh Sách Khách Hàng',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'Users'=>$search_user,
        ]);
    }
    public function search_ctsp(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;

        $search_ctsp = DB::table('bien_thes')
        ->join('productts', 'bien_thes.san_pham_id', '=', 'productts.id')
        ->join('sizes', 'bien_thes.size_id', '=', 'sizes.id')
        ->join('maus', 'bien_thes.mau_id', '=', 'maus.id')
        ->select('productts.name', 'sizes.tensize', 'maus.tenmau','bien_thes.id','bien_thes.SL')
        ->where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.ctsp.list',[
            'title'=>'Danh Sách CTSP',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'ctsps'=>$search_ctsp,
        ]);
    }
    public function search_uservl(Request $request){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $hdvl=Cart::all()->count();
        $keywords = $request->keywords_submit;
        $search_uservl = Customer::where('name','like','%'.$keywords.'%')->orderByDesc('id')
        ->paginate(10);
        return view('admin.carts.customer',[
            'title'=>'Danh Sách Hóa Đơn',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'hdvls'=>$hdvl,
            'customers'=>$search_uservl,
        ]);
    }
}
