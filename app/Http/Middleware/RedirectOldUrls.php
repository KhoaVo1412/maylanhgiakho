<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\DB;

class RedirectOldUrls
{
    public function handle($request, Closure $next)
    {
        // Lấy URL hiện tại của yêu cầu
        $currentUrl = $request->getRequestUri();

        // Tìm URL trong bảng 'redirects'
        $redirect = DB::table('redirects')->where('old_url', $currentUrl)->first();

        // Nếu tìm thấy URL cũ, chuyển hướng đến URL mới
        if ($redirect) {
            return redirect($redirect->new_url, 301);
        }

        // Nếu không có chuyển hướng, tiếp tục xử lý yêu cầu
        return $next($request);
    }
}
