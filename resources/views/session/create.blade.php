<x-layout bodyClass="bg-gray-200">
@if(session('success'))
    <h1>{{session('success')}}</h1>
@endif
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <!-- Navbar -->
                    <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>
        <main class="main-content  mt-0">
            <div class="page-header align-items-start min-vh-100"
                style="background-image: url('../assets/img/back2.jpg');">
                <!-- <span class="mask bg-gradient-dark opacity-1"></span> -->
                <div class="container mt-5">
                    <div class="row signin-margin">
                        <div class="col-lg-4 col-md-8 col-12 mx-auto">
                            <div class="card z-index-0 fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Đăng Nhập</h4>
                                        <div class="row mt-3">
                                            <h6 class='text-white text-center'>
                                                <span class="font-weight-normal">Demo:</span> Tài Khoản SuperAdmin
                                                <br>
                                                <span class="font-weight-normal">Email:</span> dangkhoa@gmail.com
                                                <br>
                                                <span class="font-weight-normal">Mật Khẩu:</span> 123456</h6>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                        @csrf
                                        @if (Session::has('status'))
                                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                                            <span class="text-sm">{{ Session::get('status') }}</span>
                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                   
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="">
                                        </div>
                                        @error('email')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Mật Khẩu</label>
                                            <input type="password" class="form-control" name="password" value=''>
                                        </div>
                                        @error('password')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                        <div class="form-check form-switch d-flex align-items-center my-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label mb-0 ms-2" for="rememberMe">Nhớ Tài Khoản</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Đăng Nhập</button>
                                        </div>
                                        <p class="mt-4 text-sm text-center">
                                            <!-- Chưa Có Tài Khoản? -->
                                            <a href="{{ route('register') }}"
                                                class="text-primary text-gradient font-weight-bold"></a>
                                        </p>
                                        <p class="text-sm text-center">
                                            Quên Mật Khẩu? Lấy Lại Mật Khẩu Tại 
                                            <a href="{{ route('verify') }}"
                                                class="text-primary text-gradient font-weight-bold">Đây</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.guest></x-footers.guest>
            </div>
        </main>
        @push('js')
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script>
    $(function() {

    var text_val = $(".input-group input").val();
    if (text_val === "") {
      $(".input-group").removeClass('is-filled');
    } else {
      $(".input-group").addClass('is-filled');
    }
});
</script>
@endpush
</x-layout>
