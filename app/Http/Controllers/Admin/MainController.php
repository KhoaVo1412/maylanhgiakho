<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MainController extends Controller
{
    public function index(){
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        if (Gate::allows('is-admin')) {
            return view('admin.home', [
                'icons'=>'<i class="fa fa-home" aria-hidden="true"></i>',
                'title'=>'Trang Admin',
                'spss'=>$sp,
                'hds'=>$hd,
                'users'=>$user,
                'sp_view'=>$view_sp,
                'hdvls'=>$hdvl
            ]);
        }
        else{
            return view('admin.users.err');
        }
    }

}
