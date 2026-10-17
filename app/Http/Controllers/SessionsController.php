<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Session;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store(Request $req)
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }
        $email=$req->input('email');
        

        $email=User::where('email',$email)
        ->first();
        if($email){
            if($email->TT==0){
                Auth::logout();
                 return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa!!!');
            }
            // elseif($email->is_admin == 1){
            //     Auth::logout();
            //      return redirect()->back()->with('error', 'Tài khoản của cua quan tri vien!');
            // }
            session()->regenerate();
        return redirect('/');

        }

        
    }

    public function show(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }

    public function update(){

        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(String::random(60));
                    
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('/loginuser')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        // if (auth()->user()->status == 0) {
        //     auth()->logout();
        //     return redirect('/login')->withSuccess('Bạn Đã Bị Admin Ban ,Liên Hệ 0969696969 Để Biết Thêm Thông Tin Chi Tiết');
        //  }
        // auth()->logout();
        // return redirect('/loginuser');
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function viewdoimk()
    {
        return view('doimk');
    }
    public function doimk(Request $request)
    {
        $customer_id = Auth()->user()->id;
        $customer_password = Auth()->user()->password;
        $passold = $request->passwordold;
        $pass = $request->password;
        $repass = $request->password_confirmation;
        $newpass = FacadesHash::make($pass);
        if(FacadesHash::check($passold,$customer_password)){
            if($pass ==  $repass){
                User::where('id',$customer_id)->update(['password'=>$newpass]);
                Session::flash('success','Cập nhật mật khẩu thành công.');
            }else{
                Session::flash('error','Mật khẩu không trùng khớp.');
            }
         }
        else{
            Session::flash('error','Mật khẩu cũ không trùng khớp.');
        }
        return redirect('/viewdoimk');   
     }


}
