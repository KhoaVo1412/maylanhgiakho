@extends('main')

@php
    $metaDesc = !empty($tintuc->description) 
        ? strip_tags($tintuc->description) 
        : ($tintuc->name . ' - Cẩm nang máy lạnh chính hãng giá sỉ, hướng dẫn sử dụng và kinh nghiệm chọn mua từ MayLanhGiaKho.');
    $cleanMetaDesc = Str::limit($metaDesc, 160);
@endphp

@push('title')
{{ $tintuc->name }} - MayLanhGiaKho
@endpush

@section('meta_description', $cleanMetaDesc)

@section('content')
    <!-- Main SEO Header for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        {{ $tintuc->name }} - Máy Lạnh Giá Kho
    </h1>

    <!-- Mount Point for ReactJS News Detail Application -->
    <div id="react-news-detail-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 650px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải bài viết {{ $tintuc->name }}...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="news-detail-initial-data" type="application/json">
        {!! json_encode([
            'tintuc' => $tintuc,
            'otherPosts' => $otherPosts,
            'featuredProducts' => $featuredProducts,
            'csrf_token' => csrf_token(),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback for Non-JS Crawlers & Search Engines -->
    <noscript>
        <article class="container" style="padding: 40px 15px; max-width: 900px; margin: 0 auto;">
            <p><a href="{{ url('/') }}">Trang chủ</a> / <a href="{{ url('/tintuc') }}">Tin tức</a></p>
            <h2>{{ $tintuc->name }}</h2>
            <p><em>Ngày đăng: {{ $tintuc->created_at ? $tintuc->created_at->format('d/m/Y') : '' }} | Chuyên mục: {{ $tintuc->danhMuc->name ?? 'Cẩm nang' }}</em></p>
            @if ($tintuc->image)
                <div style="margin: 20px 0; text-align: center;">
                    <img src="{{ asset($tintuc->image) }}" alt="{{ $tintuc->name }}" style="max-width: 100%; border-radius: 8px;">
                </div>
            @endif
            @if (!empty($tintuc->description))
                <p style="font-weight: bold; font-size: 16px; color: #334155;">{{ $tintuc->description }}</p>
            @endif
            <div style="font-size: 16px; line-height: 1.7; color: #1e293b;">
                {!! $tintuc->detail_descriptions !!}
            </div>
            @if ($otherPosts->count())
                <div style="margin-top: 50px; border-top: 2px solid #e2e8f0; padding-top: 25px;">
                    <h3>Bài Viết Liên Quan Khác</h3>
                    <ul>
                        @foreach ($otherPosts as $post)
                            <li style="margin-bottom: 10px;">
                                <a href="{{ url('tintuc-detail/' . $post->slug) }}">{{ $post->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </article>
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