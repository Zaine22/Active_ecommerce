<section class="mb-2 mb-md-3 mt-2 mt-md-3">
    <div class="container">
        <!-- Products Section -->
        <div class="row no-gutters">
            <div class="col-xl-4 col-lg-6">
                <div class="h-100 w-100 overflow-hidden">
                    <a href="{{ route('auction_products.all') }}" class="hov-scale-img">
                        <img class="img-fit lazyload mx-auto h-100 has-transition"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset(get_setting('auction_banner_image', null, get_system_language()->code)) }}"
                            alt="{{ env('APP_NAME') }} promo"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                </div>
            </div>
            @php
                $products = get_auction_products(6, null);
            @endphp
            <div class="col-xl-8 col-lg-6">
                <div class="border p-3 p-lg-4 h-100">
                    <!-- Top Section -->
                    <div class="d-flex mb-3 mb-md-4 align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ translate('Auction Products') }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('auction_products.all') }}">{{ translate('View All Products') }}</a>
                        </div>
                    </div>
                    <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="2" data-xxl-items="2" data-xl-items="2" data-lg-items="1" data-md-items="2" data-sm-items="1" data-xs-items="1"  data-arrows="true" data-dots="false">
                        @php
                            $init = 0 ;
                            $end = 2 ;
                        @endphp
                        @for ($i = 0; $i < 2; $i++)
                            <div class="carousel-box">
                                @foreach ($products as $key => $product)
                                    @if ($key >= $init && $key <= $end)
                                        <div class="position-relative has-transition hov-animate-outline p-2">
                                            <div class="row hov-scale-img">
                                                <div class="col-5">
                                                    <a href="{{ route('auction-product', $product->slug) }}" class="d-block overflow-hidden h-100px h-sm-120px h-md-140px text-center p-2">
                                                        <img class="img-fluid h-100 lazyload mx-auto has-transition"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                            alt="{{  $product->getTranslation('name')  }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                    </a>
                                                </div>
                                                <div class="col p-2 ">
                                                    <h3 class="fw-400 fs-14 text-truncate-2 lh-1-4 mb-0 h-35px mb-3 d-none d-md-block pr-3">
                                                        <a href="{{ route('auction-product', $product->slug) }}" class="d-block text-reset hov-text-primary">{{  $product->getTranslation('name')  }}</a>
                                                    </h3>
                                                    <div class="fs-14">
                                                        <span class="text-secondary">{{ translate('Starting Bid') }}</span><br>
                                                        <span class="fw-700 text-primary">{{ single_price($product->starting_bid) }}</span>
                                                    </div>
                                                    @php 
                                                        $highest_bid = $product->bids->max('amount');
                                                        $min_bid_amount = $highest_bid != null ? $highest_bid+1 : $product->starting_bid; 
                                                    @endphp
                                                    <button class="btn btn-primary btn-sm rounded-0 mt-3" onclick="bid_single_modal({{ $product->id }}, {{ $min_bid_amount }})">{{ translate('Place Bid') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            
                                @php
                                    $init += 3;
                                    $end += 3;
                                @endphp
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>