<?php

namespace App\Http\Controllers;

use App\Models\DanhMucTinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\TinTuc;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class BaiVietController extends Controller
{
    public function show_index()
    {
        $tintuc = TinTuc::all();
        return view('tintuc', [
            'tintucs' => $tintuc,
        ]);
    }
    public function show_detail($slug)
    {
        $tintuc = TinTuc::with('danhMuc')->where('slug', $slug)->firstOrFail();
        $otherPosts = TinTuc::with('danhMuc')->where('slug', '!=', $slug)->orderBy('id', 'desc')->take(8)->get();
        $featuredProducts = Productt::where('active', 1)->orderBy('view', 'desc')->take(4)->get();

        return view('tintuc_detail', compact('tintuc', 'otherPosts', 'featuredProducts'));
    }
    public function index()
    {
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();

        $dmbv = DanhMucTinTuc::all();
        return view('admin.danhmucbaiviet.list', [
            'icons' => '<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Danh Sách danhmucbaiviet',
            'dmbv' => $dmbv,
            'spss' => $sp,
            'hds' => $hd,
            'users' => $user,
            'sp_view' => $view_sp,
            'hdvls' => $hdvl

        ]);
    }
    public function create()
    {
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();
        return view('admin.danhmucbaiviet.add', [
            'icons' => '<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm Loại Sản Phẩm',
            'spss' => $sp,
            'hds' => $hd,
            'users' => $user,
            'sp_view' => $view_sp,
            'hdvls' => $hdvl
        ]);
    }
    public function store(Request $request)
    {
        $requestData = $request->all();
        $check_ten = DanhMucTinTuc::where('name', $requestData['name'])->first();
        if ($check_ten) {
            Session::put('error', 'Trùng tên danh mục.');
            return redirect()->back();
        }
        // dd($requestData);
        DanhMucTinTuc::create([
            'name' => $requestData['name'],
            'status' => 'Hoạt động',
        ]);
        // Set success message
        Session::put('message', 'Thêm danh mục thành công.');
        return redirect()->back();
    }
    public function show($baiviet)
    {
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();
        $edit_danhmuc = DanhMucTinTuc::where('id', $baiviet)->first();
        return view('admin.danhmucbaiviet.edit', [
            'edit_danhmuc' => $edit_danhmuc,
            'icons' => '<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Sua danh muc',
            'spss' => $sp,
            'hds' => $hd,
            'users' => $user,
            'sp_view' => $view_sp,
            'hdvls' => $hdvl
        ]);
    }

    public function update(Request $request, $baiviet)
    {
        $requestData = $request->all();
        $danhmucRS = DanhMucTinTuc::find($baiviet);
        $duplicate = DanhMucTinTuc::where('name', $requestData['name'])->where('id', '!=', $baiviet)->exists();
        if ($duplicate) {
            Session::put('error', 'Trùng tên danh mục.');
            return redirect()->back()->withInput();
        }
        if ($danhmucRS) {
            $danhmucRS->update([
                'name' => $requestData['name'],
            ]);
            Session::put('message', 'Cập nhật danh mục thành công.');
        } else {
            Session::put('error', 'danh mục không tồn tại.');
            return redirect()->back()->withInput();
        }

        return redirect('admin/danhmucbaiviets/list'); // Ensure 'all-DanhMucTinTuc' matches your route name

    }

    public function destroy($baiviet)
    {

        $baiviets = DanhMucTinTuc::where('id', $baiviet)->first();
        if ($baiviets) {
            $baiviets->delete();
            return true;
        }
    }
}
