<?php

namespace App\Http\Controllers;

use App\Models\TinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\DanhMucTinTuc;
use App\Models\HoaDon;
use App\Models\Productt;
use App\Models\User;

class TinTucController extends Controller
{
    public function index()
    {
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();

        $tintuc = TinTuc::all();
        return view('admin.tintuc.list', [
            'icons' => '<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'Danh Sách danhmucbaiviet',
            'tintucs' => $tintuc,
            'spss' => $sp,
            'hds' => $hd,
            'users' => $user,
            'sp_view' => $view_sp,
            'hdvls' => $hdvl
        ]);
    }
    public function create()
    {
        $dm = DanhMucTinTuc::all();
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();
        // dd($all_product);
        return view('admin.tintuc.add', [
            'icons' => '<i class="fa fa-plus-circle" aria-hidden="true"></i>',
            'title' => 'Thêm Loại Sản Phẩm',
            'dm' => $dm,
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
        $check_ten = TinTuc::where('name', $requestData['name'])->first();
        if ($check_ten) {
            Session::put('error', 'Trùng tên tin tức.');
            return redirect()->back();
        }
        if ($request->has('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $imageName = time() . '.' . $extension;

            $path = 'news/';
            $file->move($path, $imageName); // Adjust storage path as needed
        }
        $slug = Str::slug($requestData['name']);
        // dd($requestData);
        TinTuc::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'detail_descriptions' => $requestData['detail_descriptions'],
            'danh_muc_tin_tuc_id' => $requestData['danh_muc_tin_tuc_id'],
            'image' => $path . $imageName,
            'slug' => $slug,
        ]);
        // Set success message
        Session::put('message', 'Thêm tin tức thành công.');
        return redirect()->back();
    }
    public function show($id)
    {
        $sp = Productt::all()->count();
        $hd = HoaDon::all()->count();
        $user = User::all()->count();
        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();
        $hdvl = Cart::all()->count();
        $edit_tintuc = TinTuc::where('id', $id)->first();
        $dm = DanhMucTinTuc::all();
        return view('admin.tintuc.edit', [
            'edit_tintuc' => $edit_tintuc,
            'icons' => '<i class="fa fa-link" aria-hidden="true"></i>',
            'title' => 'sua tin tuc',
            'spss' => $sp,
            'hds' => $hd,
            'users' => $user,
            'sp_view' => $view_sp,
            'dm' => $dm,
            'hdvls' => $hdvl
        ]);
    }
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $newRS = TinTuc::find($id);

        // Kiểm tra trùng tên tin tức
        $duplicate = TinTuc::where('name', $requestData['name'])->where('id', '!=', $id)->exists();
        if ($duplicate) {
            Session::put('error', 'Trùng tên tin tức.');
            return redirect()->back()->withInput();
        }

        // Xử lý upload file ảnh
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            
            if ($newRS->image && file_exists(public_path($newRS->image))) {
                unlink(public_path($newRS->image));
            }
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('news/'), $fileName); // Save to public directory

              if (!$filePath) {
                Session::put('error', 'Failed to store file.');
                return redirect()->back()->withInput();
            }

            $requestData['image'] = 'news/' . $fileName; // Save path in the database
        } else {
            $requestData['image'] = $newRS->image;
        }

        $slug = Str::slug($requestData['name']);
        $newRS->update([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'detail_descriptions' => $requestData['detail_descriptions'],
            'danh_muc_tin_tuc_id' => $requestData['danh_muc_tin_tuc_id'],
            'image' => $requestData['image'],
            'slug' => $slug,
        ]);
        // dd($newRS);
        Session::put('message', 'Cập nhật tin tức thành công.');

        return redirect('admin/tintucs/list');
    }


    public function destroy($id)
    {
        TinTuc::where('id', $id)->delete();
        Session::put('message', 'Xóa tin tức thành công.');
        return redirect('admin/tintucs/list');
    }
}
