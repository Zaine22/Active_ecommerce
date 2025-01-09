@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = get_single_category($category_id)->meta_title;
        $meta_description = get_single_category($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = get_single_brand($brand_id)->meta_title;
        $meta_description = get_single_brand($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title         = get_setting('meta_title');
        $meta_description   = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')
    <!-- Breadcrumb -->
    <section class="mb-4 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-lg-left text-center">
                    <h3 class="fw-700 fs-20 fs-md-24 text-dark">{{ translate('All Auction Products') }}</h3>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb justify-content-center justify-content-lg-end bg-transparent p-0">
                        <li class="breadcrumb-item has-transition opacity-60 hov-opacity-80">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <span class="text-dark">{{ translate('All Auction Products') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- All Auction Products -->
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white px-3 pt-3">
                <div class="row gutters-16 row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 border-top border-left">
                    @foreach ($products as $key => $product)
                        <div class="col text-center border-right border-bottom hov-scale-img has-transition hov-shadow-out z-1">
                            <div class="position-relative">
                                <a href="{{ route('auction-product', $product->slug) }}" class="d-block p-3">
                                    <img class="lazyload h-sm-120px h-md-210px img-fit mx-auto has-transition"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="{{  $product->getTranslation('name')  }}" title="{{  $product->getTranslation('name')  }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="p-md-3 p-2 text-center">
                                <h3 class="fw-400 fs-14 text-truncate-2 lh-1-4 mb-0 h-35px mb-2">
                                    <a href="{{ route('auction-product', $product->slug) }}" class="d-block text-reset hov-text-primary"
                                        title="{{  $product->getTranslation('name')  }}">{{  $product->getTranslation('name')  }}</a>
                                </h3>
                                <div class="fs-14">
                                    <span class="fw-700 text-primary">{{ single_price($product->starting_bid) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="aiz-pagination aiz-pagination-center mt-4">
                    {{ $products->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        
    </script>
@endsection
