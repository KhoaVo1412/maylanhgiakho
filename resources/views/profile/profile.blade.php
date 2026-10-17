<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--===============================================================================================-->
<link rel="icon" type="image/png" href="/template/images/icons/favicon.png"/>
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
<link rel="stylesheet" type="text/css" href="/template/css/main.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="/template/css/style.css">

<link href="/template/vendor/fontawesome/css/all.min.css" rel="stylesheet"/>
   <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body>
    @include('header')
    @extends('slidebarprofile')
    @section('main-admin')
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="padding: 7px 0 0 0;">
        <div class="container">
                
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class='fas fa-angle-left' style='font-size:36px'></i>                
            </a>
            <a class="navbar-brand" href="{{ url('/') }}">
                Quay về trang chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>  
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('update.profile') }}" >
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        @php($profile_image = auth()->user()->profile_image)
                        <img class="rounded-circle mt-5" height="200px" width="200px" src="@if($profile_image == null) https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg  @else {{ asset("storage/$profile_image") }} @endif" id="image_preview_container">
                        <span class="font-weight-bold">
                            <input type="file" name="profile_image" id="profile_image"  class="form-control">
                        </span>
                        
                    </div>
                </div>
                <div class="col-md-8 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Thông tin cá nhân</h4>
                        </div>
                        <div class="row" id="res"></div>
                        <div class="row mt-2">

                            <div class="col-md-6">
                                <label class="labels">Tên</label>
                                <input type="text" name="name" class="form-control" placeholder="first name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Mail</label>
                                <input type="text" name="email" disabled class="form-control" value="{{ auth()->user()->email }}" placeholder="Email">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Số Điện Thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Địa Chỉ</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ auth()->user()->address }}" placeholder="Address">
                            </div>
                        </div>
                        <div class="row mt-2">
                                @include("select.selectlist_profile")
                        </div>
                    </div>        
                    <div class="text-center" style="position: absolute"><button id="btn" class="btn btn-primary profile-button" type="submit">Lưu</button></div>
                </div>
            </div>
    
        </form>   
       
        <form action="/viewdoimk" method="get" style="">
            <div class="text-center"><button id="btn" class="btn btn-primary profile-button" type="submit">Đổi Mật Khẩu</button></div>
        </form>
    </div>
 
   
     
<script src="{{ asset('js/profileupdate.js') }}"></script>
@endsection
</body>
</html> 