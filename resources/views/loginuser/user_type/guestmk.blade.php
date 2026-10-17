@extends('loginuser.app')

@section('guest')
        @yield('content')
        @include('loginuser.footers.guest.footer')
@endsection
