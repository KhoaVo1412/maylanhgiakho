@extends('main')

@push('title')
Chính Sách Bảo Hành Chính Hãng - MayLanhGiaKho
@endpush

@section('meta_description', 'Chính sách bảo hành máy lạnh chính hãng tại MayLanhGiaKho (Điện Máy Phan Hòa). Bảo hành điện tử tận nhà, 1 đổi 1 trong 30 ngày, hỗ trợ kỹ thuật 24/7.')

@section('content')
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Chính Sách Bảo Hành Máy Lạnh Chính Hãng - MayLanhGiaKho
    </h1>

    <div id="react-policy-root">
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải chính sách bảo hành...</div>
            </div>
        </div>
    </div>

    <script id="policy-initial-data" type="application/json">
        {!! json_encode([
            'policyKey' => 'bao-hanh',
            'hotline' => '0583 593 999',
            'hotline_sub' => '0353 353 286',
            'address' => '582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh',
            'email' => 'Phanvanhoa231102@gmail.com'
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <noscript>
        <div class="container" style="padding: 40px 15px; font-family: sans-serif;">
            <h2>Chính Sách Bảo Hành - MayLanhGiaKho (Điện Máy Phan Hòa)</h2>
            <p>Địa chỉ: 582 An Dương Vương, Bình Phú, TP. Hồ Chí Minh. Hotline: 0583 593 999</p>
            <p>Tất cả sản phẩm máy lạnh phân phối tại MayLanhGiaKho đều là hàng chính hãng 100%, bảo hành điện tử chính hãng từ nhà sản xuất Daikin, Panasonic, Toshiba, Casper, Mitsubishi...</p>
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection