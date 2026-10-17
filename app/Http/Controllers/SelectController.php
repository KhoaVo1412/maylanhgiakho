<?php

namespace App\Http\Controllers;

use App\Models\PhuongXa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TinhTP;
use App\Models\QuanHuyen;



class SelectController extends Controller
{
    public function prodfunct(){

		$prod=TinhTP::all();//get data from table
		return view('select.selectlist',compact('prod'));//sent data to view

	}

    public function selectList(){

		$prod=TinhTP::all();//get data from table
		return view('select.selectlist_profile',compact('prod'));//sent data to view

	}

	public function findQuanHuyen(Request $request){

        $data=QuanHuyen::where('tinh_tp_id', $request->id)->get();
        return response()->json($data);
	}
    public function findPhuongXa(Request $request){

        $data=PhuongXa::where('quan_huyen_id', $request->id)->get();
        return response()->json($data);
	}





}

