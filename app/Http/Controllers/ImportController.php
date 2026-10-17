<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class ImportController extends Controller
{

       public function create(){
        return view('exportfile.import');
       }
       public function upload(Request $request){
        //
       

       }

}
