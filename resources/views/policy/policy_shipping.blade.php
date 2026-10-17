@extends('main')

@push('title')
Chính Sách Vận Chuyển & Giao Hàng Siêu Tốc - MayLanhGiaKho
@endpush

@section('meta_description', 'Chính sách vận chuyển máy lạnh tại MayLanhGiaKho. Giao hàng & lắp đặt siêu tốc trong 2H - 3H, miễn phí nội thành TP.HCM, an toàn nguyên đai nguyên kiện.')

@section('content')
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Chính Sách Vận Chuyển & Giao Hàng Siêu Tốc - MayLanhGiaKho
    </h1>

    <div id="react-policy-root">
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải chính sách vận chuyển...</div>
            </div>
        </div>
    </div>

    <script id="policy-initial-data" type="application/json">
        {!! json_encode([
            'policyKey' => 'van-chuyen',
            'hotline' => '0583 593 999',
            'hotline_sub' => '0353 353 286',
            'address' => '582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh',
            'email' => 'Phanvanhoa231102@gmail.com'
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <noscript>
        <div class="container" style="padding: 40px 15px; font-family: sans-serif;">
            <h2>Chính Sách Vận Chuyển - MayLanhGiaKho</h2>
            <p>Giao hàng hỏa tốc trong 2H - 3H tại TP.HCM. Miễn phí vận chuyển nội thành. Hotline: 0583 593 999.</p>
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection