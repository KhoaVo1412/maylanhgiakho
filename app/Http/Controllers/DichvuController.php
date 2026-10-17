<?php



namespace App\Http\Controllers;



use App\Models\DichVu;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Str;

use App\Models\Cart;

use App\Models\HoaDon;

use App\Models\Productt;

use App\Models\User;



class DichvuController extends Controller

{

    public function index()

    {

        $sp = Productt::all()->count();

        $hd = HoaDon::all()->count();

        $user = User::all()->count();

        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();

        $hdvl = Cart::all()->count();



        $dichvu = DichVu::all();

        return view('admin.dichvus.list', [

            'icons' => '<i class="fa fa-link" aria-hidden="true"></i>',

            'title' => 'Danh Sách Dịch Vụ',

            'dichvus' => $dichvu,

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

        // dd($all_product);

        return view('admin.dichvus.add', [

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

        $check_ten = DichVu::where('name', $requestData['name'])->first();

        if ($check_ten) {

            Session::put('error', 'Trùng tên dịch vụ.');

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

        DichVu::create([

            'name' => $requestData['name'],

            'type' => $requestData['type'],

            'description' => $requestData['description'],

            'detail_descriptions' => $requestData['detail_descriptions'],

            'image' => $path . $imageName,

            'slug' => $slug,

        ]);

        // Set success message

        Session::put('message', 'Thêm dịch vụ thành công.');

        return redirect()->back();
    }

    public function show($id)

    {

        $sp = Productt::all()->count();

        $hd = HoaDon::all()->count();

        $user = User::all()->count();

        $view_sp = Productt::orderBy('view', 'DESC')->take(10)->get();

        $hdvl = Cart::all()->count();

        $edit_dichvus = DichVu::where('id', $id)->first();

        return view('admin.dichvus.edit', [

            'edit_dichvus' => $edit_dichvus,

            'icons' => '<i class="fa fa-link" aria-hidden="true"></i>',

            'title' => 'sua dichvus',

            'spss' => $sp,

            'hds' => $hd,

            'users' => $user,

            'sp_view' => $view_sp,

            'hdvls' => $hdvl

        ]);
    }

    public function update(Request $request, $id)

    {

        $requestData = $request->all();

        $newRS = DichVu::find($id);



        // Kiểm tra trùng tên dịch vụ

        $duplicate = DichVu::where('name', $requestData['name'])->where('id', '!=', $id)->exists();

        if ($duplicate) {

            Session::put('error', 'Trùng tên dịch vụ.');

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

            'type' => $requestData['type'],

            'description' => $requestData['description'],

            'detail_descriptions' => $requestData['detail_descriptions'],
            'image' => $requestData['image'],

            'slug' => $slug,

        ]);

        // dd($newRS);

        Session::put('message', 'Cập nhật dịch vụ thành công.');



        return redirect('admin/dichvus/list');
    }





    public function destroy($id)

    {

        DichVu::where('id', $id)->delete();

        Session::put('message', 'Xóa dịch vụ thành công.');

        return redirect('admin/dichvus/list');
    }

    public function show_index()

    {

        $dichvu = DichVu::all();

        return view('dichvu', [

            'dichvus' => $dichvu,

        ]);
    }
    public function show_detail($slug)
    {
        $dvposts = DichVu::where('slug', '!=', $slug)->get(); // Get all other posts except the current one

        $dichvu = DichVu::where('slug', $slug)->firstOrFail(); // Find post by slug
        return view('dichvu_detail', compact('dichvu', 'dvposts'));
    }
}
