<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserManagerService
{
    public function getUser(){
        return User::orderByDesc('id')->paginate(10);
    }
}