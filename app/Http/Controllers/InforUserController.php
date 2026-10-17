<?php

namespace App\Http\Controllers;

use App\Models\PhuongXa;
use App\Models\QuanHuyen;
use App\Models\TinhTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class InforUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    { $prod=TinhTP::all();
        return view('profile.profile', [
            'prod'=>$prod
        ]);

    }

    public function findQuanHuyen(Request $request){

        $data=QuanHuyen::where('tinh_tp_id', $request->id)->get();
        return response()->json($data);
	}
    public function findPhuongXa(Request $request){

        $data=PhuongXa::where('quan_huyen_id', $request->id)->get();
        return response()->json($data);
	}
    public function updateProfile(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        # check if user profile image is null, then validate
        if (auth()->user()->profile_image == null) {
             $validate_image = Validator::make($request->all(), [
                'profile_image' => ['required', 'image', 'max:1000']
            ]);
             # check if their is any error in image validation
            if ($validate_image->fails()) {
                return response()->json(['code' => 400, 'msg' => $validate_image->errors()->first()]);
            }
        }

        # check if their is any error
        if ($validated->fails()) {
            return response()->json(['code' => 400, 'msg' => $validated->errors()->first()]);
        }

        # check if the request has profile image
        if ($request->hasFile('profile_image')) {
            $imagePath = 'storage/'.auth()->user()->profile_image;
            # check whether the image exists in the directory
            if (File::exists($imagePath)) {
                # delete image
                File::delete($imagePath);
            }
            $profile_image = $request->profile_image->store('profile_images', 'public');
        }

        # update the user info
        auth()->user()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $profile_image ?? auth()->user()->profile_image // if not updating a new profile image, update with existing one
        ]);
        return response()->json(['code' => 200, 'msg' => 'profile updated successfully.']);
    }


    
}
