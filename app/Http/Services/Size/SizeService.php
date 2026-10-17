<?php

namespace App\Http\Services\Size;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SizeService
{
    public function insert($request)
    {
        try{
            $request->except('_token');
            Size::create($request->input());
            Session::flash('success', 'Add Size Success.');
        }catch(\Exception $err){
            Session::flash('error', 'Add Size Error.');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }
    public function get()
    {
        return Size::orderByDesc('id')->paginate(15);
    }

    public function update($request, $size)
    {
        try {
            $size->fill($request->input());
            $size->save();
            Session::flash('success', 'Update success');
        } catch (\Exception $err) {
            Session::flash('success', 'Update fail.');
            Log::info($err->getMessage());
            
            return false;
        }

        return true;
        
    }
    public function destroy($request)
    {
        $size = Size::where('id', $request->input('id'))->first();
        if ($size) {
            $size->delete();
            return true;
        }
        return false;
    }

    
    public function show()
    {
        return Size::where('active', 1)->orderByDesc('sort_by')->get();
    }
}