@extends('main')

@push('title')
Tin Tức & Cẩm Nang Sử Dụng Máy Lạnh Tiết Kiệm Điện - MayLanhGiaKho
@endpush

@section('meta_description', 'Tin tức máy lạnh, cẩm nang chọn mua máy lạnh chính hãng giá sỉ, bí quyết sử dụng máy lạnh Inverter tiết kiệm điện 40% và kiến thức điện lạnh bổ ích.')

@section('content')
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Tin Tức & Cẩm Nang Máy Lạnh - Mẹo Sử Dụng Tiết Kiệm Điện & Tư Vấn Chọn Mua
    </h1>

    <!-- Mount Point for ReactJS News Application -->
    <div id="react-news-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 600px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải tin tức & cẩm nang máy lạnh...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="news-initial-data" type="application/json">
        {!! json_encode([
            'tintucs' => $tintucs,
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Các Bài Viết & Cẩm Nang Máy Lạnh</h2>
            @if ($tintucs->count())
                @foreach ($tintucs as $post)
                    <div style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                        <h3><a href="{{ url('tintuc-detail/' . $post->slug) }}">{{ $post->name }}</a></h3>
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

    {{-- Vite Scripts --}}
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endsection