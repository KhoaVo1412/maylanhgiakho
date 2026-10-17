@extends('main')

@push('title')
Thông Báo Tuyển Dụng Nhân Sự Điện Lạnh - Điện Máy Phan Hòa
@endpush

@section('meta_description', 'Điện Máy Phan Hòa (MayLanhGiaKho) tuyển dụng nhân sự: Kế toán bán hàng, Kỹ thuật viên điện lạnh, Nhân viên giao hàng, Điều phối. Thu nhập hấp dẫn, đãi ngộ tốt.')

@section('content')
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Thông Báo Tuyển Dụng Nhân Sự Điện Lạnh - Điện Máy Phan Hòa
    </h1>

    <div id="react-policy-root">
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải thông tin tuyển dụng...</div>
            </div>
        </div>
    </div>

    <script id="policy-initial-data" type="application/json">
        {!! json_encode([
            'policyKey' => 'tuyen-dung',
            'hotline' => '0583 593 999',
            'hotline_sub' => '0353 353 286',
            'address' => '582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh',
            'email' => 'Phanvanhoa231102@gmail.com'
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <noscript>
        <div class="container" style="padding: 40px 15px; font-family: sans-serif;">
            <h2>Thông Báo Tuyển Dụng - Điện Máy Phan Hòa</h2>
            <p>Địa chỉ: 582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh. Điện thoại: 0583 593 999 - 039 6789 012.</p>
            <p>Tuyển dụng các vị trí: Nhân viên Kế toán, Kỹ thuật viên Lắp đặt, Nhân viên Giao hàng, Nhân viên Điều phối.</p>
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection