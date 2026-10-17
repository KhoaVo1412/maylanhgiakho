<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Giỏ Hàng Của Bạn
            </span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            @php $sumPriceCart = 0; @endphp
            <ul class="header-cart-wrapitem w-full">
                @if (!empty($productts) && (is_countable($productts) || is_array($productts)) && count($productts) > 0)
                    @foreach($productts as $key => $productt)
                        @php
                            $price = \App\Helpers\Helper::price($productt->price, $productt->price_sale);
                            $sumPriceCart += $productt->price_sale != 0 ? $productt->price_sale : $productt->price;
                        @endphp
                        <li class="header-cart-item flex-w flex-t m-b-12">
                            <a href="/san-pham/{{ $productt->id }}-{{ Str::slug($productt->name, '-') }}.html">
                                <div class="header-cart-item-img">
                                    <img src="{{ $productt->thumb }}" alt="IMG">
                                </div>
                            </a>

                            <div class="header-cart-item-txt p-t-8">
                                <a href="/san-pham/{{ $productt->id }}-{{ Str::slug($productt->name, '-') }}.html" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                    {{ $productt->name }}
                                </a>

                                <span class="header-cart-item-info">
                                    {!! $price !!}
                                </span>
                            </div>
                        </li>
                    @endforeach
                @endif

            </ul>

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: {{ number_format($sumPriceCart, '0', '', '.') }}
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="/carts" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        Xem Giỏ Hàng
                    </a>

                    <a href="/carts" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                        Kiểm Tra
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
