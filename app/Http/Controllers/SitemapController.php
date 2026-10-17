<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Menu;
use App\Models\Productt;

class SitemapController extends Controller
{
    public function index()
    {
        // Khởi tạo XML header
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Thêm URL của danh mục
        $menus = Menu::all(); // Lấy tất cả danh mục từ cơ sở dữ liệu
        foreach ($menus as $menu) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . URL::to('danh-muc/' . $menu->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $menu->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }

        // Thêm URL của sản phẩm
        $products = Productt::all(); // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        foreach ($products as $product) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . URL::to('san-pham/' . $product->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }

        // Kết thúc sitemap
        $sitemap .= '</urlset>';

        // Trả về nội dung XML
        return response($sitemap, 200)->header('Content-Type', 'application/xml');
    }
}
