@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card rounded-0 shadow-none border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('All Bidded Products') }}</h5>
        </div>
        <div class="card-body py-0">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0">#</th>
                        <th width="40%" >{{ translate('Product')}}</th>
                        <th data-breakpoints="md">{{ translate('My Bid')}}</th>
                        <th data-breakpoints="md">{{ translate('Highest Bid')}}</th>
                        <th data-breakpoints="md">{{ translate('End Date')}}</th>
                        <th class="text-right pr-0">{{ translate('Action')}}</th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    @foreach ($bids as $key => $bid_id)
                        @php
                            $bid = get_auction_product_bid_info($bid_id->id);
                        @endphp
                        <tr>
                            <td class="pl-0" style="vertical-align: middle;">{{ sprintf('%02d', ($key+1) + ($bids->currentPage() - 1)*$bids->perPage()) }}</td>
                            <td class="text-dark" style="vertical-align: middle;">
                                <a href="{{ route('auction-product', $bid->product->slug) }}" class="text-reset hov-text-primary d-flex align-items-center">
                                    <img class="lazyload img-fit size-70px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($bid->product->thumbnail_img) }}"
                                        alt="{{  $bid->product->getTranslation('name')  }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <span class="ml-1">{{ $bid->product->getTranslation('name') }}</span>
                                </a>
                            </td>
                            <td class="fw-700" style="vertical-align: middle;">{{ single_price($bid->amount) }}</td>
                            <td style="vertical-align: middle;">
                                @php $highest_bid = $bid->where('product_id',$bid->product_id)->max('amount'); @endphp
                                <span class="badge badge-inline @if($bid->amount < $highest_bid) badge-danger @else badge-success @endif p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">
                                    {{ single_price($highest_bid) }}
                                </span>
                            </td>
                            <td style="vertical-align: middle;">
                                @if($bid->product->auction_end_date < strtotime("now"))
                                    {{ translate('Ended') }}
                                @else
                                    {{ date('d.m.Y H:i:s', $bid->product->auction_end_date) }}
                                @endif
                            </td>
                            <td class="text-right pr-0" style="vertical-align: middle;">
                                @php
                                    $order = null;
                                    $order_detail = get_order_details_by_product($bid->product_id);
                                    if($order_detail != null ){
                                        $order = get_user_order_by_id($order_detail->order_id);
                                    }
                                @endphp
                                @if($bid->product->auction_end_date < strtotime("now") && $bid->amount == $highest_bid && $order == null)
                                    @php
                                        $carts = get_user_cart();
                                    @endphp
                                    @if(count($carts) > 0 )
                                        @php
                                            $cart_has_this_product = false;
                                            foreach ($carts as $key => $cart){
                                                if($cart->product_id == $bid->product_id){
                                                    $cart_has_this_product = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if($cart_has_this_product)
                                            <button type="button" class="btn btn-sm btn-primary buy-now fw-600 rounded-0" data-toggle="tooltip" title="{{ translate('Item alreday added to the cart.') }}">
                                                {{ translate('Buy') }}
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-primary buy-now fw-600 rounded-0" data-toggle="tooltip" title="{{ translate('Remove other items to add auction product.') }}">
                                                {{ translate('Buy') }}
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary buy-now fw-600 rounded-0" onclick="showAuctionAddToCartModal({{ $bid->product_id }})">
                                            {{ translate('Buy') }}
                                        </button>
                                    @endif
                                @elseif($order != null)
                                    <span class="badge badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;" >{{ translate('Purchased') }}</span>
                                @else
                                    N\A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
            	{{ $bids->links() }}
          	</div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript">
    function showAuctionAddToCartModal(id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('auction.cart.showCartModal') }}', {_token: AIZ.data.csrf, id:id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            AIZ.plugins.slickCarousel();
            AIZ.plugins.zoom();
            AIZ.extra.plusMinus();
            getVariantPrice();
        });
    }
</script>
@endsection
