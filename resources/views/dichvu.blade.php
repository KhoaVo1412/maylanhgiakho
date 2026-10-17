@extends('main')

@push('title')
Dịch Vụ Lắp Đặt, Vệ Sinh & Sửa Chữa Máy Lạnh Chuyên Nghiệp - MayLanhGiaKho
@endpush

@section('meta_description', 'Dịch vụ lắp đặt máy lạnh, bảo trì vệ sinh máy lạnh, nạp gas, sửa chữa máy lạnh chuyên nghiệp tại TP.HCM. Có mặt sau 30 phút, bảo hành dài hạn, giá sỉ tại kho.')

@section('content')
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Dịch Vụ Máy Lạnh Chuyên Nghiệp - Lắp Đặt, Vệ Sinh, Nạp Gas & Sửa Chữa Tận Nơi TP.HCM
    </h1>

    <!-- Mount Point for ReactJS Services Application -->
    <div id="react-services-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải dịch vụ máy lạnh...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="services-initial-data" type="application/json">
        {!! json_encode([
            'dichvus' => $dichvus,
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Dịch Vụ Máy Lạnh Của Chúng Tôi</h2>
            @if ($dichvus->count())
                @foreach ($dichvus as $post)
                    <div style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                        <h3><a href="{{ url('dichvu-detail/' . $post->slug) }}">{{ $post->name }}</a></h3>
                        <p><em>Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</em></p>
                        <p>{{ Str::limit($post->description, 160) }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Bảng Giá Dịch Vụ Lắp Đặt Máy Lạnh, Vật Tư Ống Đồng & Vệ Sinh Máy Lạnh TP.HCM
    </h1>

    <!-- Mount Point for ReactJS PriceList Application -->
    <div id="react-pricelist-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải bảng giá dịch vụ máy lạnh...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="pricelist-initial-data" type="application/json">
        {!! json_encode([
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Bảng Giá Dịch Vụ Lắp Đặt & Bảo Trì Máy Lạnh</h2>
            <table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background: #0284c7; color: #fff;">
                        <th>STT</th>
                        <th>Nội dung công việc</th>
                        <th>ĐVT</th>
                        <th>Đơn giá (VNĐ)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.1</td>
                        <td>Nhân công lắp đặt máy lạnh treo tường 1.0 - 1.5 HP</td>
                        <td>Bộ</td>
                        <td>350.000</td>
                    </tr>
                    <tr>
                        <td>1.2</td>
                        <td>Nhân công lắp đặt máy lạnh treo tường 2.0 - 2.5 HP</td>
                        <td>Bộ</td>
                        <td>500.000 - 700.000</td>
                    </tr>
                    <tr>
                        <td>2.1</td>
                        <td>Ống gas 6.4x9.5mm Thái Lan dày 0.71mm (1.0 - 1.5 HP)</td>
                        <td>Mét</td>
                        <td>150.000</td>
                    </tr>
                    <tr>
                        <td>2.2</td>
                        <td>Ống gas 6.4x12.7mm Thái Lan dày 0.71mm (2.0 - 2.5 HP)</td>
                        <td>Mét</td>
                        <td>190.000</td>
                    </tr>
                    <tr>
                        <td>3.1</td>
                        <td>Bảo trì, vệ sinh máy lạnh treo tường (tặng cân chỉnh gas)</td>
                        <td>Bộ</td>
                        <td>200.000</td>
                    </tr>
                    <tr>
                        <td>3.5</td>
                        <td>Nạp gas bổ sung R32, R410A chính hãng</td>
                        <td>Bộ</td>
                        <td>350.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>

    {{-- Vite Scripts --}}
    {{-- @viteReactRefresh
    @vite(['resources/js/app.jsx']) --}}
    

    {{-- Vite Scripts --}}
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endsection