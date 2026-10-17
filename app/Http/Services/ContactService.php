<?php

namespace App\Http\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ContactService
{
    public function addContactsv($request)
    {
        try {
            DB::beginTransaction();
                Contact::create([
                    'name' => $request->input('ten'),
                    'address'=> $request->input('diachi'),
                    'phone'=> $request->input('dienthoai'),
                    'email' => $request->input('email'),
                    'title' => $request->input('tieude'),
                    'content' => $request->input('noidung'),
                ]);    
            DB::commit();
            Session::flash('success', 'Gửi thành công.');
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Gửi thất bại.');
            return false;
        }

        return true;
    }
}