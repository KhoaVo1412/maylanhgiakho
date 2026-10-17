<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Productt;

class SearchController extends Controller
{


    public function search()
    {
        if($key=request()->key)
        $productts = Productt::where("name", "like", "%$key%")->paginate(15);
        return view('search', compact('productts'));
    }
}

