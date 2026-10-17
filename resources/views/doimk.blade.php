<html>
    <head>
        <meta charset="UTF-8">
        <title>Đổi Mật Khẩu</title>
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
    <style>
            .mainDiv {
            display: flex;
            min-height: 100%;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
            font-family: 'Open Sans', sans-serif;
        }
        .cardStyle {
            width: 500px;
            border-color: white;
            background: #fff;
            padding: 36px 0;
            border-radius: 4px;
            margin: 30px 0;
            box-shadow: 0px 0 2px 0 rgba(0,0,0,0.25);
        }
            #signupLogo {
            max-height: 100px;
            margin: auto;
            display: flex;
            flex-direction: column;
            }
            .formTitle{
            font-weight: 600;
            margin-top: 20px;
            color: #2F2D3B;
            text-align: center;
            }
            .inputLabel {
            font-size: 12px;
            color: #555;
            margin-bottom: 6px;
            margin-top: 24px;
            }
            .inputDiv {
                width: 70%;
                display: flex;
                flex-direction: column;
                margin: auto;
            }
            input {
            height: 40px;
            font-size: 16px;
            border-radius: 4px;
            border: none;
            border: solid 1px #ccc;
            padding: 0 11px;
            }
            input:disabled {
            cursor: not-allowed;
            border: solid 1px #eee;
            }
            .buttonWrapper {
            margin-top: 40px;
            }
            .submitButton {
                width: 70%;
                height: 40px;
                margin: auto;
                display: block;
                color: #fff;
                background-color: #065492;
                border-color: #065492;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
                box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
                border-radius: 4px;
                font-size: 14px;
                cursor: pointer;
            }
            .submitButton:disabled,
            button[disabled] {
            border: 1px solid #cccccc;
            background-color: #cccccc;
            color: #666666;
            }

            #loader {
            position: absolute;
            z-index: 1;
            margin: -2px 0 0 10px;
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #666666;
            width: 14px;
            height: 14px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
    </style>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background:#1d1f20">
        <div class="container">   
            <a class="navbar-brand" href="{{ url('/profile') }}">
                <i class='fas fa-angle-left' style='font-size:36px; color:white'></i>                
            </a>
            <a class="navbar-brand" href="{{ url('/profile') }}" style="color: white">
                Trở Về Trang Thông Tin
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>  
            </div>
        </div>
    </nav>
        <div class="mainDiv" style="background: #1d1f20">

        <div class="cardStyle" style="background: rgba(4, 4, 4, 0.56);">
            <form role="form" action="/doimk" method="POST">
                @csrf
                <h3 style="text-align: center; color:white">
                    Đổi Mật Khẩu
                </h3>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {!!session()->get('success')!!}
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!!session()->get('error')!!}
                </div>
                @endif
                <div class="inputDiv">
                    <label class="inputLabel" for="password" style="color: white">Mật Khẩu Cũ</label>
                    <input id="password" name="passwordold" type="password" aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="inputDiv">
                    <label class="inputLabel" for="password" style="color: white">Mật Khẩu Mới</label>
                    <input id="password" name="password" type="password" aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword" style="color: white">Xác Nhận Mật Khẩu Mới</label>
                    <input id="password-confirmation" name="password_confirmation" type="password" aria-label="Password-confirmation" aria-describedby="Password-addon">
                    @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="buttonWrapper">
                    <button type="submit" class="submitButton pure-button pure-button-primary">
                    <span>Thay Đổi</span>
                    {{-- <span id="loader"></span> --}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</html>
<script src="{{ asset('js/profileupdate.js') }}"></script>