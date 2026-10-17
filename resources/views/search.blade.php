@extends('main')
@section('content')
<section class="bg0 p-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10" style="padding-top: 160px;">
            <h3 class="ltext-103 cl5">
                Tổng quan về sản phẩm
            </h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                    Tất cả các sản phẩm đang tìm kiếm
                </button>
            </div>
        </div>

        <div id="loadProduct">
            @include('productts.list')
        </div>


        <!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45" id="button-loadMore">
            <input type="hidden" value="1" id="page">
            <a onclick="loadMore()" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Xem Thêm
            </a>
        </div>
    </div>
</section>
@endsection
