@extends('main')

@push('title')
Liên Hệ Máy Lạnh Giá Kho - Tổng Kho Máy Lạnh Chính Hãng Giá Sỉ Tại TP.HCM
@endpush

@section('meta_description', 'Liên hệ Máy Lạnh Giá Kho - 582 An Dương Vương, P.11, Q.6, TP.HCM. Hotline tư vấn & kỹ thuật: 0583 593 999 - 0353 353 286. Hỗ trợ 24/7, có mặt sau 30 phút.')

@section('content')
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Liên Hệ Tổng Kho Máy Lạnh Giá Kho - Hotline Kỹ Thuật & Mua Hàng 24/7
    </h1>

    <!-- Mount Point for ReactJS Contact Application -->
    <div id="react-contact-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải trang liên hệ...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="contact-initial-data" type="application/json">
        {!! json_encode([
            'csrf_token' => csrf_token(),
            'flash_success' => Session::get('success') ?? '',
            'flash_error' => Session::get('error') ?? '',
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Thông Tin Liên Hệ Máy Lạnh Giá Kho</h2>
            <p><strong>Địa chỉ:</strong> 582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh</p>
            <p><strong>Hotline:</strong> 0583 593 999 - 0353 353 286</p>
            <p><strong>Email:</strong> phanvanhoa231102@gmail.com</p>
            <p><strong>Website:</strong> https://maylanhgiakho.ai.vn/</p>
            
            <form action="{{ url('/contactadd') }}" method="POST" style="margin-top: 25px; max-width: 600px;">
                @csrf
                <div style="margin-bottom: 12px;">
                    <input name="ten" type="text" placeholder="Họ và tên *" style="width: 100%; padding: 8px;" required />
                </div>
                <div style="margin-bottom: 12px;">
                    <input name="dienthoai" type="text" placeholder="Số điện thoại *" style="width: 100%; padding: 8px;" required />
                </div>
                <div style="margin-bottom: 12px;">
                    <input name="diachi" type="text" placeholder="Địa chỉ *" style="width: 100%; padding: 8px;" required />
                </div>
                <div style="margin-bottom: 12px;">
                    <input name="tieude" type="text" placeholder="Chủ đề *" style="width: 100%; padding: 8px;" required />
                </div>
                <div style="margin-bottom: 12px;">
                    <textarea name="noidung" rows="4" placeholder="Nội dung *" style="width: 100%; padding: 8px;" required></textarea>
                </div>
                <button type="submit" style="background: #0284c7; color: #fff; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer;">
                    Gửi Liên Hệ
                </button>
            </form>
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>

    {{-- Vite Scripts --}}
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endsection