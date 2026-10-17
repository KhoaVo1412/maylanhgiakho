<!-- Modern Floating Contact Bar -->
<style>
    .photheme-pc-contact-bar {
        position: fixed;
        left: 24px;
        bottom: 30px;
        z-index: 99999;
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: auto;
    }
    .photheme-pc-contact-bar li {
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        overflow: visible !important;
        background: none !important;
        background-image: none !important;
    }
    .photheme-pc-contact-bar li.zalo,
    .photheme-pc-contact-bar li.hotline {
        background: none !important;
        background-image: none !important;
        height: auto !important;
        overflow: visible !important;
    }
    .photheme-pc-contact-bar li.zalo a {
        display: inline-flex !important;
        align-items: center !important;
        width: auto !important;
        height: auto !important;
        white-space: nowrap !important;
        overflow: visible !important;
        gap: 10px;
        background: #ffffff !important;
        border: 1.5px solid #0068ff !important;
        padding: 5px 16px 5px 6px !important;
        border-radius: 40px !important;
        box-shadow: 0 6px 18px rgba(0, 104, 255, 0.2) !important;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }
    .photheme-pc-contact-bar li.zalo a:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 104, 255, 0.3);
        background: #f0f7ff;
    }
    .photheme-pc-contact-bar .zalo-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #0068ff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 104, 255, 0.35);
        animation: zalo-ripple 2.5s infinite;
    }
    .photheme-pc-contact-bar .zalo-text-wrap {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .photheme-pc-contact-bar .zalo-sub-text {
        font-size: 10px;
        font-weight: 700;
        color: #0068ff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .photheme-pc-contact-bar .zalo-title-text {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.3px;
    }
    .photheme-pc-contact-bar li.hotline a {
        display: inline-flex !important;
        align-items: center !important;
        width: auto !important;
        height: auto !important;
        white-space: nowrap !important;
        overflow: visible !important;
        gap: 10px;
        background: #ffffff !important;
        border: 1.5px solid #10b981 !important;
        padding: 5px 18px 5px 6px !important;
        border-radius: 40px !important;
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.2) !important;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }
    .photheme-pc-contact-bar li.hotline a:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(16, 185, 129, 0.32);
        background: #f0fdf4;
    }
    .photheme-pc-contact-bar .hotline-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
        animation: phone-shake 2.2s infinite ease-in-out;
    }
    .photheme-pc-contact-bar .hotline-text-wrap {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }
    .photheme-pc-contact-bar .hotline-sub-text {
        font-size: 10px;
        font-weight: 700;
        color: #059669;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .photheme-pc-contact-bar .hotline-number-text {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.5px;
    }
    @keyframes phone-shake {
        0% { transform: rotate(0) scale(1); }
        10% { transform: rotate(-22deg) scale(1.05); }
        20% { transform: rotate(22deg) scale(1.05); }
        30% { transform: rotate(-22deg) scale(1.05); }
        40% { transform: rotate(22deg) scale(1.05); }
        50% { transform: rotate(0) scale(1); }
        100% { transform: rotate(0) scale(1); }
    }
    @keyframes zalo-ripple {
        0% { box-shadow: 0 0 0 0 rgba(0, 104, 255, 0.6); }
        65% { box-shadow: 0 0 0 12px rgba(0, 104, 255, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 104, 255, 0); }
    }
    .photheme-mobile-contact-bar {
        display: none;
    }
    @media (max-width: 991px) {
        .photheme-pc-contact-bar { display: none; }
        .photheme-mobile-contact-bar {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: fixed;
            left: 16px;
            bottom: 20px;
            z-index: 99999;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .photheme-mobile-contact-bar li { list-style: none; }
        .photheme-mobile-contact-bar li.zalo a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #0068ff;
            box-shadow: 0 4px 14px rgba(0, 104, 255, 0.4);
            animation: zalo-ripple 2.5s infinite;
        }
        .photheme-mobile-contact-bar li.hotline a {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1.5px solid #10b981;
            padding: 4px 14px 4px 5px;
            border-radius: 30px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            text-decoration: none;
        }
        .photheme-mobile-contact-bar .mobile-phone-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            animation: phone-shake 2.2s infinite;
        }
        .photheme-mobile-contact-bar .mobile-phone-num {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
        }
    }
</style>

<!-- Floating Contact Bar Buttons (PC & Mobile) -->
<ul class='photheme-pc-contact-bar'>
    <li class='zalo'>
        <a href='https://zalo.me/0583593999' rel='nofollow' target='_blank' title='Chat Zalo tư vấn báo giá'>
            <div class="zalo-icon-circle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.03 2 11C2 13.56 3.19 15.85 5.11 17.43L4.2 21.08C4.1 21.48 4.49 21.82 4.87 21.66L9.08 19.86C10.02 20.14 11 20.29 12 20.29C17.52 20.29 22 16.26 22 11.29C22 6.32 17.52 2 12 2Z" fill="#ffffff"/>
                    <path d="M7.8 8.5H11.2C11.5 8.5 11.7 8.8 11.5 9.1L8.9 12.8H11.3C11.5 12.8 11.7 13 11.7 13.2V13.8C11.7 14 11.5 14.2 11.3 14.2H7.7C7.4 14.2 7.2 13.9 7.4 13.6L10.1 9.9H7.8C7.6 9.9 7.4 9.7 7.4 9.5V8.9C7.4 8.7 7.6 8.5 7.8 8.5ZM13.8 8.5H14.8C15 8.5 15.2 8.7 15.2 8.9V13.8C15.2 14 15 14.2 14.8 14.2H13.8C13.6 14.2 13.4 14 13.4 13.8V8.9C13.4 8.7 13.6 8.5 13.8 8.5Z" fill="#0068ff"/>
                </svg>
            </div>
            <div class="zalo-text-wrap">
                <span class="zalo-sub-text">Tư Vấn Zalo</span>
                <span class="zalo-title-text">Báo Giá Nhanh</span>
            </div>
        </a>
    </li>
    <li class='hotline'>
        <a href='tel:0583593999' rel='nofollow' target='_blank' title='Gọi hotline 0583.593.999'>
            <div class="hotline-icon-circle">
                <i class="fa fa-phone"></i>
            </div>
            <div class="hotline-text-wrap">
                <span class="hotline-sub-text">Hotline 24/7</span>
                <span class="hotline-number-text">0583.593.999</span>
            </div>
        </a>
    </li>
</ul>

<ul class='photheme-mobile-contact-bar'>
    <li class='zalo'>
        <a href='https://zalo.me/0583593999' rel='nofollow' target='_blank' title='Zalo'>
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.03 2 11C2 13.56 3.19 15.85 5.11 17.43L4.2 21.08C4.1 21.48 4.49 21.82 4.87 21.66L9.08 19.86C10.02 20.14 11 20.29 12 20.29C17.52 20.29 22 16.26 22 11.29C22 6.32 17.52 2 12 2Z" fill="#ffffff"/>
                <path d="M7.8 8.5H11.2C11.5 8.5 11.7 8.8 11.5 9.1L8.9 12.8H11.3C11.5 12.8 11.7 13 11.7 13.2V13.8C11.7 14 11.5 14.2 11.3 14.2H7.7C7.4 14.2 7.2 13.9 7.4 13.6L10.1 9.9H7.8C7.6 9.9 7.4 9.7 7.4 9.5V8.9C7.4 8.7 7.6 8.5 7.8 8.5ZM13.8 8.5H14.8C15 8.5 15.2 8.7 15.2 8.9V13.8C15.2 14 15 14.2 14.8 14.2H13.8C13.6 14.2 13.4 14 13.4 13.8V8.9C13.4 8.7 13.6 8.5 13.8 8.5Z" fill="#0068ff"/>
            </svg>
        </a>
    </li>
    <li class='hotline'>
        <a href='tel:0583593999' rel='nofollow' target='_blank'>
            <div class="mobile-phone-icon">
                <i class="fa fa-phone"></i>
            </div>
            <span class="mobile-phone-num">0583.593.999</span>
        </a>
    </li>
</ul>

<!-- Mount Point for ReactJS Header Application -->
<div id="react-header-root">
    <!-- Initial SSR fallback bar to prevent layout shift before hydration -->
    <div style="background: #3b5998; color: #fff; padding: 8px 15px; font-size: 13px; font-family: sans-serif;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <a href="tel:0583593999" style="color: #fff; text-decoration: none; margin-right: 15px;">📞 0583593999</a>
                <span style="opacity: 0.8;">✉️ Phanvanhoa231102@gmail.com</span>
            </div>
            <div>
                @if(Auth::check())
                    <a href="/profile" style="color: #fff; text-decoration: none;">👤 {{ Auth::user()->name }}</a>
                @else
                    <a href="/loginuser" style="color: #fff; text-decoration: none; font-weight: bold;">Đăng nhập</a>
                @endif
            </div>
        </div>
    </div>
    <div style="background: #fff; border-bottom: 1px solid #e2e8f0; padding: 12px 15px;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="/"><img src="/template/images/icons/iconml.png" alt="Logo" style="height: 48px;"></a>
            <div style="color: #64748b; font-size: 14px;">Đang tải thanh điều hướng...</div>
        </div>
    </div>
</div>

<!-- Header Initial Data Injection -->
<script id="header-initial-data" type="application/json">
    {!! json_encode([
        'user' => Auth::check() ? [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone ?? '',
            'address' => Auth::user()->address ?? '',
            'avatar' => Auth::user()->profile_image ? (str_starts_with(Auth::user()->profile_image, 'http') ? Auth::user()->profile_image : asset('storage/' . Auth::user()->profile_image)) : null,
        ] : null,
        'cart_count' => !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0,
        'menus' => $menus ?? [],
        'hotline' => '0583593999',
        'email' => 'Phanvanhoa231102@gmail.com',
        'working_hours' => 'Thứ 2 - CN',
        'current_path' => request()->path(),
    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
</script>

<!-- SEO Fallback -->
<noscript>
    <nav style="background: #fff; padding: 10px 15px; border-bottom: 1px solid #ddd;">
        <a href="/">Trang Chủ</a> |
        <a href="/dichvu">Dịch Vụ</a> |
        <a href="/banggia">Bảng Giá</a> |
        <a href="/contact">Liên Hệ</a> |
        <a href="/tintuc">Tin Tức</a> |
        <a href="/carts">Giỏ Hàng</a>
    </nav>
</noscript>