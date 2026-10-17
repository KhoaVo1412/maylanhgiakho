<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $sp=Productt::all()->count();
        $hd=HoaDon::all()->count();
        $user=User::all()->count();
        $view_sp=Productt::orderBy('view','DESC')->take(10)->get();
        $hdvl=Cart::all()->count();
        return view('admin.users.login', [
            'title' =>'Login systems',
            'spss'=>$sp,
            'hds'=>$hd,
            'users'=>$user,
            'sp_view'=>$view_sp,
            'hdvls'=>$hdvl
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
    public function store(Request $request)
    {
        // $remember = isset($request->input('remember')) ?true:false;
        $this->validate($request, [
            'email'=>'required|email:filter',
            'password'=>'required'
        ]);
        if(Auth::attempt([
            'email'=> $request->input('email'),
            'password'=>$request->input('password')
        ],$request->input('remember'))) {
            return redirect()->route('admin');
        }
        
        Session::flash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
        // Session::flash('success', 'Login success');
        return redirect()->back();
    }

}
