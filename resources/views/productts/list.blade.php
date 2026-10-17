<div class="row isotope-grid">
    @foreach($productts as $key => $productt)
    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women" data-brand="{{ $productt->menu_id }}" data-name="{{ strtolower($productt->name) }}" data-price="{{ $productt->price_sale > 0 ? $productt->price_sale : $productt->price }}" itemscope itemtype="http://schema.org/Product">
        <!-- Modern Premium Product Card -->
        <div class="block2">
            @csrf
            
            <!-- Product Image Section -->
            <div class="block2-pic hov-img0 mb-img">
                <a href="/san-pham/{{ $productt->slug }}">
                    <img src="{{ $productt->thumb }}" alt="{{ $productt->name }}" itemprop="image">
                </a>
            </div>

            <!-- Product Details Section -->
            <div class="block2-txt">
                <!-- Product Name (SEO friendly h3 tag) -->
                <a href="/san-pham/{{ $productt->slug }}" id="mb-name" itemprop="url">
                    <h3 itemprop="name">{{ $productt->name }}</h3>
                </a>

                <!-- Rating representation for premium visual quality -->
                <div class="product-rating" style="color: #f59e0b; font-size: 0.8rem; margin-bottom: 0.5rem;">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <span style="color: #64748b; font-size: 0.75rem; margin-left: 4px;">(5.0)</span>
                </div>

                <!-- Product Pricing -->
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <a href="/san-pham/{{ $productt->slug }}" id="mb-price">
                        <!-- Original Price -->
                        @if($productt->price > 0)
                            <span style="text-decoration: line-through;">
                                {!! \App\Helpers\Helper::price($productt->price) !!} VND
                            </span>
                            <br>
                        @endif

                        <!-- Sale Price -->
                        <span class="stext-105 cl3" itemprop="price" content="{{ $productt->price_sale }}">
                            {!! \App\Helpers\Helper::price($productt->price, $productt->price_sale) !!} VND
                        </span>
                        <meta itemprop="priceCurrency" content="VND">
                    </a>
                </div>

                <!-- Premium Action Button -->
                <a href="/san-pham/{{ $productt->slug }}" class="product-action-btn">
                    Xem Chi Tiết
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
