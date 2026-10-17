@extends('main')

@php
$metaDescription = $menu->description ?? "Máy Lạnh {$menu->name} Chính Hãng Mới 100% Nguyên Đai Nguyên Kiện - Phân Phối Giá Sỉ Trực Tiếp Tại Kho";
@endphp

@section('meta_description', $metaDescription)

@push('title')
Máy Lạnh {{ $menu->name }} - Bảng Giá Máy Lạnh {{ $menu->name }} Chính Hãng Tại Kho
@endpush

@section('content')
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Máy Lạnh {{ $menu->name }} Chính Hãng - Tổng Kho Phân Phối Giá Sỉ Toàn Quốc
    </h1>

    <!-- Mount Point for ReactJS Category Application -->
    <div id="react-category-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải danh mục máy lạnh {{ $menu->name }}...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="category-initial-data" type="application/json">
        {!! json_encode([
            'menu' => $menu,
            'products' => $productts->items(),
            'menus' => $menus,
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Máy Lạnh {{ $menu->name }} Chính Hãng</h2>
            <div class="row">
                @foreach($productts as $sp)
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 25px;">
                        <div style="border: 1px solid #e2e8f0; padding: 15px; border-radius: 10px; background: #fff;">
                            <a href="/san-pham/{{ $sp->slug }}">
                                <img src="{{ $sp->thumb }}" alt="{{ $sp->name }}" style="max-width: 100%; height: 180px; object-fit: contain;">
                                <h3 style="font-size: 14px; margin: 10px 0; color: #1e293b;">{{ $sp->name }}</h3>
                            </a>
                            <div style="color: #ef4444; font-weight: bold; font-size: 16px;">
                                {!! \App\Helpers\Helper::price($sp->price, $sp->price_sale) !!} VND
                            </div>
                            <a href="/san-pham/{{ $sp->slug }}" style="display: inline-block; margin-top: 8px; color: #0284c7; font-weight: 600;">Xem chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($menu->content)
                <div style="margin-top: 40px;">
                    {!! $menu->content !!}
                </div>
            @endif
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