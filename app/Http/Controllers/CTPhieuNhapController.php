<?php

namespace App\Http\Controllers;

use App\Models\CTPhieuNhap;
use App\Http\Requests\StoreCTPhieuNhapRequest;
use App\Http\Requests\UpdateCTPhieuNhapRequest;

class CTPhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            return view('contact');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCTPhieuNhapRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CTPhieuNhap $cTPhieuNhap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CTPhieuNhap $cTPhieuNhap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCTPhieuNhapRequest $request, CTPhieuNhap $cTPhieuNhap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CTPhieuNhap $cTPhieuNhap)
    {
        //
    }
}
