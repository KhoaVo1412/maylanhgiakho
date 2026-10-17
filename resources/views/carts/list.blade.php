@extends('main')

@push('title')
Giỏ Hàng Của Bạn - Máy Lạnh Giá Kho
@endpush

@section('content')
    <!-- Hidden SEO H1 for Crawlers -->
    <h1 style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">
        Giỏ Hàng Của Bạn - Tổng Kho Máy Lạnh Chính Hãng Giá Sỉ
    </h1>

    <!-- Mount Point for ReactJS Shopping Cart Application -->
    <div id="react-cart-root">
        <!-- Initial skeleton while script initializes -->
        <div style="min-height: 500px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
            <div style="text-align: center; color: #0284c7;">
                <div style="display: inline-block; width: 44px; height: 44px; border: 4px solid #e0f2fe; border-top-color: #0284c7; border-radius: 50%; animation: acSpin 0.8s linear infinite;"></div>
                <div style="margin-top: 14px; font-weight: 700; font-family: sans-serif; font-size: 15px;">Đang tải thông tin giỏ hàng...</div>
            </div>
        </div>
    </div>

    <!-- Data Injection for Instant Hydration -->
    <script id="cart-initial-data" type="application/json">
        {!! json_encode([
            'items' => collect($cartContent ?? [])->values()->map(function($item) {
                return [
                    'rowId' => $item->rowId,
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => (float)$item->price,
                    'qty' => (int)$item->qty,
                    'thumb' => $item->options->image ?? '/template/images/icons/iconml.png',
                    'slug' => \Illuminate\Support\Str::slug($item->name, '-'),
                ];
            })->toArray(),
            'coupon' => $coupon,
            'user' => Auth::check() ? [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'phone' => Auth::user()->phone ?? '',
                'email' => Auth::user()->email ?? '',
                'address' => Auth::user()->address ?? '',
            ] : null,
            'provinces' => $prod ?? [],
            'csrf_token' => csrf_token(),
            'flash_success' => session('success'),
            'flash_error' => session('error'),
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
    </script>

    <!-- SEO Fallback -->
    <noscript>
        <div class="container" style="padding: 40px 15px;">
            <h2>Giỏ hàng của bạn</h2>
            @if(isset($productts) && count($productts) > 0)
                <ul>
                    @foreach($productts as $p)
                        <li>{{ $p->name }} - {{ number_format($p->price_sale ?: $p->price) }} đ</li>
                    @endforeach
                </ul>
            @else
                <p>Giỏ hàng đang trống.</p>
            @endif
        </div>
    </noscript>

    <style>
        @keyframes acSpin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection