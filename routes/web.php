<?php

use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BienTheController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OnlineCheckoutController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InforUserController;
use App\Http\Controllers\MauController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TinTucController;
use App\Http\Controllers\DichvuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// admin/users/login
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    // Artisan::call('route:clear');
    // Artisan::call('view:clear');
    // Artisan::call('permission:cache-reset');

    return "Cache cleared successfully!";
});
//Admin
Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        #danhmucbaiviet
        Route::prefix('danhmucbaiviets')->group(function () {
            Route::get('add', [BaiVietController::class, 'create']);
            Route::post('add', [BaiVietController::class, 'store']);
            Route::get('list', [BaiVietController::class, 'index']);
            Route::get('edit/{baiviet}', [BaiVietController::class, 'show']);
            Route::post('edit/{baiviet}', [BaiVietController::class, 'update']);
            Route::DELETE('destroy', [BaiVietController::class, 'destroy']);
        });

        Route::prefix('tintucs')->group(function () {
            Route::get('add', [TinTucController::class, 'create']);
            Route::post('add', [TinTucController::class, 'store']);
            Route::get('list', [TinTucController::class, 'index']);
            Route::get('edit/{id}', [TinTucController::class, 'show']);
            Route::post('edit/{id}', [TinTucController::class, 'update']);
            Route::DELETE('destroy/{id}', [TinTucController::class, 'destroy'])->name('tintucs.destroy');
        });
        Route::prefix('dichvus')->group(function () {
            Route::get('add', [DichvuController::class, 'create']);
            Route::post('add', [DichvuController::class, 'store']);
            Route::get('list', [DichvuController::class, 'index']);
            Route::get('edit/{id}', [DichvuController::class, 'show']);
            Route::post('edit/{id}', [DichvuController::class, 'update']);
            Route::DELETE('destroy/{id}', [DichvuController::class, 'destroy'])->name('dichvus.destroy');
        });
        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::post('tim-kiem-category', [App\Http\Controllers\Admin\SearchController::class, 'search_category']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });
        #Product

        Route::prefix('productts')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::post('tim-kiem-product', [App\Http\Controllers\Admin\SearchController::class, 'search_product']);
            Route::get('edit/{productt}', [ProductController::class, 'show']);
            Route::post('edit/{productt}', [ProductController::class, 'update']);
            Route::DELETE('destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        #Detail Product

        Route::prefix('ctsp')->group(function () {
            Route::get('add', [BienTheController::class, 'create']);
            Route::post('add', [BienTheController::class, 'store']);
            Route::get('list', [BienTheController::class, 'index']);
            Route::post('tim-kiem-ctsp', [App\Http\Controllers\Admin\SearchController::class, 'search_ctsp']);
            Route::get('edit/{ctsp}', [BienTheController::class, 'show']);
            Route::post('edit/{ctsp}', [BienTheController::class, 'update']);
            Route::DELETE('destroy', [BienTheController::class, 'destroy']);
        });

        #Upload
        Route::post('upload/services', [UploadController::class, 'store']);

        #Sliders
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::post('tim-kiem-slider', [App\Http\Controllers\Admin\SearchController::class, 'search_slider']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });
        #size
        Route::prefix('size')->group(function () {
            Route::get('add', [SizeController::class, 'create']);
            Route::post('add', [SizeController::class, 'store']);
            Route::get('list', [SizeController::class, 'index']);
            Route::post('tim-kiem-size', [App\Http\Controllers\Admin\SearchController::class, 'search_size']);
            Route::get('edit/{size}', [SizeController::class, 'show']);
            Route::post('edit/{size}', [SizeController::class, 'update']);
            Route::DELETE('destroy', [SizeController::class, 'destroy']);
        });

        #mau
        Route::prefix('mau')->group(function () {
            Route::get('add', [MauController::class, 'create']);
            Route::post('add', [MauController::class, 'store']);
            Route::get('list', [MauController::class, 'index']);
            Route::post('tim-kiem-mau', [App\Http\Controllers\Admin\SearchController::class, 'search_color']);
            Route::get('edit/{mau}', [MauController::class, 'show']);
            Route::post('edit/{mau}', [MauController::class, 'update']);
            Route::DELETE('destroy', [MauController::class, 'destroy']);
        });

        #giamgia
        Route::prefix('giamgia')->group(function () {
            Route::get('add', [CouponController::class, 'create']);
            Route::post('add', [CouponController::class, 'store']);
            Route::get('list', [CouponController::class, 'index']);
            Route::post('tim-kiem-discount', [App\Http\Controllers\Admin\SearchController::class, 'search_discount']);
            Route::get('edit/{giamgia}', [CouponController::class, 'show']);
            Route::post('edit/{giamgia}', [CouponController::class, 'update']);
            Route::DELETE('destroy', [CouponController::class, 'destroy']);
        });

        #Customer
        Route::get('customers', [App\Http\Controllers\Admin\CartController::class, 'index']);
        Route::get('customers/view/{customer}', [App\Http\Controllers\Admin\CartController::class, 'show']);

        #Customer Login

        Route::get('customerslog', [App\Http\Controllers\Admin\CartController::class, 'indexlog']);
        Route::get('bill_processing', [App\Http\Controllers\Admin\CartController::class, 'dangxuly_admin']);
        Route::get('bill_delivering', [App\Http\Controllers\Admin\CartController::class, 'danggiao_admin']);
        Route::get('bill_finish', [App\Http\Controllers\Admin\CartController::class, 'hoanthanh_admin']);
        Route::get('bill_cancel', [App\Http\Controllers\Admin\CartController::class, 'dahuy_admin']);
        Route::get('customerslog/viewlog/{hoadon}', [App\Http\Controllers\Admin\CartController::class, 'showlog']);
        Route::post('tim-kiem-bill', [App\Http\Controllers\Admin\SearchController::class, 'search_bill']);
        Route::post('tim-kiem-user', [App\Http\Controllers\Admin\SearchController::class, 'search_user']);
        Route::post('tim-kiem-uservl', [App\Http\Controllers\Admin\SearchController::class, 'search_uservl']);
        #Customer Manager
        Route::get('customermanagers', [App\Http\Controllers\Admin\UserManagerController::class, 'index']);
        Route::get('customermanagers/view/{user}', [App\Http\Controllers\Admin\UserManagerController::class, 'show']);
    });
});
//End_Admin
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);

Route::get('dichvu', [App\Http\Controllers\DichvuController::class, 'show_index']);
Route::get('dichvu-detail/{slug}', [App\Http\Controllers\DichvuController::class, 'show_detail']);

Route::get('tintuc', [App\Http\Controllers\BaiVietController::class, 'show_index']);
Route::get('tintuc-detail/{slug}', [App\Http\Controllers\BaiVietController::class, 'show_detail']);

Route::get('danh-muc/{slug}', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{slug}', [App\Http\Controllers\ProductController::class, 'index']);

Route::post('/load-comment', [App\Http\Controllers\ProductController::class, 'load_comment']);
Route::post('/send-comment', [App\Http\Controllers\ProductController::class, 'send_comment']);
Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);

Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'delete_to_cart']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);

Route::get('static-sign-in', function () {
    return view('static-sign-in');
})->name('sign-in');

Route::get('static-sign-up', function () {
    return view('static-sign-up');
})->name('sign-up');

Route::get('/loginuser', [SessionsController::class, 'create'])->name('login_user');
Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});
Route::get('/timkiem', [SearchController::class, 'search']);
Route::get('/select', [SelectController::class, 'prodfunct']);
Route::get('/selectlist', [SelectController::class, 'selectList']);
Route::get('/findProductName', [SelectController::class, 'findQuanHuyen']);
Route::get('/findmau', [App\Http\Controllers\CartController::class, 'findmau']);
// Route::get('/findmau', [App\Http\Controllers\CartController::class, 'findsize']);

Route::get('/findPhuongXa', [SelectController::class, 'findPhuongXa']);
Route::get('/tt', [OnlineCheckoutController::class, 'create']);
Route::post('/vnpay', [App\Http\Controllers\CartController::class, 'vnpay']);
Route::get('/thanhcong', [App\Http\Controllers\CartController::class, 'thanhcong']);

Route::post('/momo', [OnlineCheckoutController::class, 'momo']);
Route::get('/ip', [ImportController::class, 'create']);
Route::post('/import', [ImportController::class, 'upload']);
Route::get('/history', [HoaDonController::class, 'index'])->name('history_order');
Route::get('/HoaDonDangXuLy', [HoaDonController::class, 'DangXuLy']);
Route::get('/HoaDonDaHuy', [HoaDonController::class, 'DaHuyHD']);
Route::get('/HoaDonDangGiao', [HoaDonController::class, 'DangGiaoHang']);
Route::get('/HoaDonDaHoanThanh', [HoaDonController::class, 'HoaDonDaHoanThanh']);
Route::get('/history/{hoadon}', [HoaDonController::class, 'showdetail']);

Route::get('/profile', [InforUserController::class, 'index'])->name('profile');

Route::post('/updateProfile', [InforUserController::class, 'updateProfile'])->name('update.profile');
Route::post('/update-cart-quantity', [App\Http\Controllers\CartController::class, 'update_cart_quantity']);
Route::get('/giohangtrong', function () {
    return view('carts.giohangtrong');
})->name('giohang');
Route::get('/tab', function () {
    return view('tabhistory');
})->name('tab');

Route::post('/capnhat2', [App\Http\Controllers\Admin\CartController::class, 'danggiao']);
Route::post('/capnhat3', [App\Http\Controllers\Admin\CartController::class, 'hoanthanh']);
Route::post('/capnhat4', [App\Http\Controllers\Admin\CartController::class, 'huydon']);
Route::post('/capnhathuy', [HoaDonController::class, 'dahuy']);

Route::post('/mualai', [HoaDonController::class, 'ud_dangxuly']);
Route::post('/filterbydate', [HoaDonController::class, 'filterbydate']);
Route::post('/dashboard-filter', [HoaDonController::class, 'dashboard_filter']);
Route::post('/days-order', [HoaDonController::class, 'days_order']);
Route::get('/days-order', [HoaDonController::class, 'days_order']);


Route::post('/chart-sp', [HoaDonController::class, 'chart_sp']);
Route::get('/chart-sp', [HoaDonController::class, 'chart_sp']);

Route::post('/tonkho', [HoaDonController::class, 'tonkho']);
Route::get('/tonkho', [HoaDonController::class, 'tonkho']);

Route::post('/trangthai', [HoaDonController::class, 'trangthai']);
Route::get('/trangthai', [HoaDonController::class, 'trangthai']);

Route::get('/test', [HoaDonController::class, 'test']);

Route::post('/update-view', [ProductController::class, 'update_view']);
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contactadd', [ContactController::class, 'addContact']);
Route::get('/print/{hoadon}', [App\Http\Controllers\Admin\CartController::class, 'convert_html_pdf']);
Route::post('/check-coupon', [App\Http\Controllers\CartController::class, 'giamgia']);
Route::post('/tim-kiem-user', [App\Http\Controllers\Admin\SearchController::class, 'search_user']);

Route::get('/viewdoimk', [SessionsController::class, 'viewdoimk']);
Route::post('/doimk', [SessionsController::class, 'doimk']);


Route::get('/slidebar', function () {
    return view('slidebarprofile');
});


Route::get('/unactive/{customer_id}', [App\Http\Controllers\Admin\UserManagerController::class, 'unactive_account']);
Route::get('/active/{customer_id}', [App\Http\Controllers\Admin\UserManagerController::class, 'active_account']);
Route::get('/banggia', function () {
    return view('banggia');
});
Route::get('/chinh-sach-bao-hanh', function () {
    return view('policy.policy', ['policyKey' => 'bao-hanh']);
});
Route::get('/chinh-sach-van-chuyen', function () {
    return view('policy.policy_shipping', ['policyKey' => 'van-chuyen']);
});
Route::get('/chinh-sach-doi-tra', function () {
    return view('policy.policy_return', ['policyKey' => 'doi-tra']);
});
Route::get('/chinh-sach-bo-mat-thong-tin', function () {
    return view('policy.policy_privacy', ['policyKey' => 'bao-mat']);
});
Route::get('/chinh-sach-bao-mat-thong-tin', function () {
    return view('policy.policy_privacy', ['policyKey' => 'bao-mat']);
});
Route::get('/chinh-sach-tuyen-dung', function () {
    return view('policy.policy_td', ['policyKey' => 'tuyen-dung']);
});
// Route::get('/linkstorage', function () {
//     Artisan::call('storage:link');
// });
