@extends('main')

@php
$metaDescription = $productt->description ?? ($productt->name . ' - Máy lạnh chính hãng mới 100% nguyên đai nguyên kiện, phân phối trực tiếp giá sỉ tại kho.');
@endphp

@section('meta_description', $metaDescription)

@push('title')
{{ $productt->name }} - Giá Sỉ Rẻ Nhất Tại Kho
@endpush

@section('content')
    <!-- Hidden SEO H1 for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        {{ $productt->name }} Chính Hãng - Tổng Kho Phân Phối Máy Lạnh Giá Sỉ
    </h1>

    <!-- Mount Point for ReactJS Product Detail Application -->
    <div id="react-product-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải chi tiết {{ $productt->name }}...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="product-initial-data" type="application/json">
        {!! json_encode([
            'productt' => $productt,
            'variants' => $variants,
            'related' => $related,
            'comments' => $comments,
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>{{ $productt->name }}</h2>
            <p>{{ $productt->description }}</p>
            <div style="color: #ef4444; font-size: 24px; font-weight: bold; margin: 20px 0;">
                {!! \App\Helpers\Helper::price($productt->price, $productt->price_sale) !!} VNĐ
            </div>
            <div>
                <img src="{{ $productt->thumb }}" alt="{{ $productt->name }}" style="max-width: 400px;">
            </div>
            @if($productt->content)
                <div style="margin-top: 30px;">
                    {!! $productt->content !!}
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