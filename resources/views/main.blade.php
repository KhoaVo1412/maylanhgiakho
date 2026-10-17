<!DOCTYPE html>
<html lang="vi-VN">

<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N8PR5LLG');
    </script>
    <!-- End Google Tag Manager -->
    <title>@stack('title')</title>
    <meta name="description"
        content="@yield('meta_description', 'Máy Lạnh Giá Kho Cam Kết Tất Cả Sản Phẩm Chính Hãng, Mới 100% Nguyên Đai Nguyên Kiện, Muahangtaikho - Mua Hàng Tại Kho')" />

    @include('head')

    {{-- Global Vite scripts so React Header and all React modules hydrate cleanly everywhere --}}
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N8PR5LLG" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Header -->
    @include('header')

    <!-- Cart -->
    @include('cart')

    <!-- Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('footer')

    <!-- Histats.com  (div with counter) -->
    <div id="histats_counter"></div>
    <!-- Histats.com  START  (aync)-->
    <script type="text/javascript">
        var _Hasync= _Hasync|| [];
        _Hasync.push(['Histats.start', '1,4932847,4,1,120,40,00010000']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
        var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
        hs.src = ('//s10.histats.com/js15_as.js');
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
    </script>
    <noscript><a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?4932847&101" alt=""
                border="0"></a></noscript>
    <!-- Histats.com  END  -->
</body>

</html>