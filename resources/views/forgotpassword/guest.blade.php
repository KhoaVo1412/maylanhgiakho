@extends('forgotpassword.app')

@section('guest')
    @if(\Request::is('login/forgot-password'))
        @include('forgotpassword.nav')
        @yield('content')
    @else
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    @include('forgotpassword.nav')
                </div>
            </div>
        </div>
        @yield('content')

    @endif
@endsection
