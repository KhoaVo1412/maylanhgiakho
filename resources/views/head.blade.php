<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Điện Máy Phan Hòa">
<meta name="publisher" content="Máy Lạnh Giá Kho">
    <meta name="keywords" content="nullnull">
<meta name="robots" content="index, follow"> <!-- Allow indexing and following links -->
<!-- Canonical Tag -->
@if (request()->is('/'))
<link rel="canonical" href="{{ url('https://maylanhgiakho.ai.vn/') }}">
@elseif (request()->is('danh-muc/*'))
<link rel="canonical" href="{{ url()->current() }}">
@elseif (request()->is('san-pham/*'))
<link rel="canonical" href="{{ url()->current() }}">
@else
<link rel="canonical" href="{{ request()->url() }}">
@endif
<meta name="google-site-verification" content="jxJwBmf9z0bepLhibzmLQWkl_2vWaM7woNBkO2tNYzc" />
<!--===============================================================================================-->
<!--<link rel="icon" type="image/png" href="/template/images/icons/favicon.png"/>-->
<link rel="icon" type="image/png" href="/template/images/icons/iconml.png" />

{{--
<link rel="stylesheet" type="text/css" href="/template/images" /> --}}
<!--=====================================/==========================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/slick/slick.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/css/util.css">

<!-- Conflicting icon_ms_zl.css removed: modern contact bar is defined in header.blade.php -->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('/public/template/css/icon_ms_zl.css') }}">-->

<!--<link rel="stylesheet" type="text/css" href="public/template/css/main.css">-->
<link rel="stylesheet" type="text/css" href="{{ asset('/template/css/main.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/css/homepage_redesign.css') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('/template/css/style.css') }}">

<link href="{{asset('/template/vendor/fontawesome/css/all.min.css')}}" rel="stylesheet" />
<!--<link href="/template/vendor/fontawesome-free-6.5.1-web/css/all.min.css" rel="stylesheet" />-->
{{--
<link href="vendor/fontawesome/css/all.min.css" rel="stylesheet" />
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" /> --}}
<meta name="csrf-token" content="{{ csrf_token() }}">