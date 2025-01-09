@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h3 class="h3">{{translate('All Delivery Boys')}}</h3>
        </div>
        @can('add_delivery_boy')
            <div class="col text-right">
                <a href="{{ route('delivery-boys.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Delivery Boy')}}</span>
                </a>
            </div>
        @endcan
    </div>
</div>


<div class="card">
    <div class="card-header d-block d-lg-flex">
        <h5 class="mb-0 h6">{{translate('Delivery Boys')}}</h5>
        <div class="">
            <form class="" id="sort_delivery_boys" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 250px;">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type email or name & Enter') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Email Address')}}</th>
                    <th data-breakpoints="lg">{{translate('Phone')}}</th>
                    <th>{{translate('Earning')}}</th>
                    <th>{{translate('Collection')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($delivery_boys as $key => $delivery_boy)
                @if ($delivery_boy->user != null)
                <tr>
                    <td>{{ ($key+1) + ($delivery_boys->currentPage() - 1)*$delivery_boys->perPage() }}</td>
                    <td>@if($delivery_boy->user->banned == 1) <i class="las la-ban text-danger" aria-hidden="true"></i> @endif {{$delivery_boy->user->name}}</td>
                    <td>{{$delivery_boy->user->email}}</td>
                    <td>{{$delivery_boy->user->phone}}</td>
                    <td>
                        {{ single_price($delivery_boy->total_earning) }}
                    </td>
                    <td>
                        {{ single_price($delivery_boy->total_collection) }}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                              <i class="las la-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                @can('edit_delivery_boy')
                                    <a href="{{route('delivery-boys.edit', $delivery_boy->user->id)}}" class="dropdown-item">
                                    {{translate('Edit')}}
                                    </a>
                                @endcan
                                @can('ban_delivery_boy')
                                    @if($delivery_boy->user->banned != 1)
                                        <a href="#" onclick="confirm_ban('{{route('delivery-boy.ban', $delivery_boy->user->id)}}');" class="dropdown-item">
                                            {{translate('Ban this delivery boy')}}
                                            <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                        </a>
                                    @else
                                        <a href="#" onclick="confirm_unban('{{route('delivery-boy.ban', $delivery_boy->user->id)}}');" class="dropdown-item">
                                            {{translate('Unban this delivery boy')}}
                                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endcan
                                @can('collect_from_delivery_boy')
                                    <a href="#" onclick="show_order_collection_modal('{{$delivery_boy->user->id}}');" class="dropdown-item">
                                        {{translate('Go to Collection')}}
                                    </a>
                                @endcan
                                @can('pay_to_delivery_boy')
                                    <a href="#" onclick="show_delivery_earning_modal('{{$delivery_boy->user->id}}');" class="dropdown-item">
                                        {{translate('Go to Payment')}}
                                    </a>
                                @endcan
                            </div>
                        </div>

                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $delivery_boys->appends(request()->input())->links() }}
        </div>
    </div>
</div>


<div class="modal fade" id="collection_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="collection-modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="payment_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="payment-modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="confirm-ban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to ban this delivery_boy?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a type="button" id="confirmation" class="btn btn-primary">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-unban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to unban this delivery_boy?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a type="button" id="confirmationunban" class="btn btn-primary">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        (function($) {
			"use strict";
        
        })(jQuery);
		
		function show_order_collection_modal(id){
            $.post('{{ route('delivery-boy.order-collection') }}',{
                _token  :'{{ @csrf_token() }}',
                id      :id
            }, function(data){
                $('#collection_modal #collection-modal-content').html(data);
                $('#collection_modal').modal('show', {backdrop: 'static'});
            });
        }

		function show_delivery_earning_modal(id){
            $.post('{{ route('delivery-boy.delivery-earning') }}',{
                _token  :'{{ @csrf_token() }}',
                id      :id
            }, function(data){
                $('#payment_modal #payment-modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
            });
        }

        function sort_delivery_boys(el){
            $('#sort_delivery_boys').submit();
        }
        function confirm_ban(url)
        {
            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }

    </script>
@endsection
