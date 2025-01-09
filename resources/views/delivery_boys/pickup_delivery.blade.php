@extends('delivery_boys.layouts.app')

@section('panel_content')
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Picked Up Delivery History') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0">{{ translate('Code')}}</th>
                        <th data-breakpoints="lg">{{ translate('Date')}}</th>
                        <th>{{ translate('Amount')}}</th>
                        <th data-breakpoints="lg">{{ translate('Delivery Status')}}</th>
                        <th data-breakpoints="lg">{{ translate('Payment Status')}}</th>
                        <th data-breakpoints="lg">{{ translate('Payment Type')}}</th>
                        <th data-breakpoints="lg">{{ translate('Mark As On The Way')}}</th>
                        <th class="text-right pr-0">{{ translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    @foreach ($pickup_deliveries as $key => $delivery)
                        <tr>
                            <!-- Code -->
                            <td class="pl-0" style="vertical-align: middle;">
                                <a href="{{route('delivery-boy.order-detail', encrypt($delivery->id))}}">{{ $delivery->code }}</a>
                            </td>
                            <!-- Date -->
                            <td class="text-secondary" style="vertical-align: middle;">
                                {{ date('d-m-Y h:i A', strtotime($delivery->delivery_history_date)) }}
                            </td>
                            <!-- Amount -->
                            <td class="fw-700" style="vertical-align: middle;">
                                {{ single_price($delivery->grand_total) }}
                            </td>
                            <!-- Delivery Status -->
                            <td class="fw-700 w-120px" style="vertical-align: middle;">
                                {{ translate(ucfirst(str_replace('_', ' ', $delivery->delivery_status))) }}
                                @if($delivery->delivery_viewed == 0)
                                    <span class="ml-1" style="color:green"><strong>*</strong></span>
                                @endif
                            </td>
                            <!-- Payment Status -->
                            <td class="w-120px" style="vertical-align: middle;">
                                @if ($delivery->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('Paid')}}</span>
                                @else
                                    <span class="badge badge-inline badge-danger p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('Unpaid')}}</span>
                                @endif
                                @if($delivery->payment_status_viewed == 0)
                                    <span class="ml-1" style="color:green"><strong>*</strong></span>
                                @endif
                            </td>
                            <!-- Payment Type -->
                            <td style="vertical-align: middle;">
                                {{ translate(ucfirst(str_replace('_', ' ', $delivery->payment_type))) }}
                            </td>
                            <!-- Switch -->
                            <td style="vertical-align: middle;">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_status(this)" value="{{ $delivery->id }}" type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <!-- Options -->
                            <td class="text-right pr-0 w-130px" style="vertical-align: middle;">
                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm" onclick="confirm_cancel_request('{{route('cancel-request', $delivery->id)}}')" title="{{ translate('Cancel') }}">
                                    <i class="las la-times"></i>
                                </a>
                                <a href="{{route('delivery-boy.order-detail', encrypt($delivery->id))}}" class="btn btn-soft-info btn-icon btn-circle btn-sm hov-svg-white" title="{{ translate('Order Details') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                        <g id="Group_24807" data-name="Group 24807" transform="translate(-1339 -422)">
                                            <rect id="Rectangle_18658" data-name="Rectangle 18658" width="12" height="1" transform="translate(1339 422)" fill="#3490f3"/>
                                            <rect id="Rectangle_18659" data-name="Rectangle 18659" width="12" height="1" transform="translate(1339 425)" fill="#3490f3"/>
                                            <rect id="Rectangle_18660" data-name="Rectangle 18660" width="12" height="1" transform="translate(1339 428)" fill="#3490f3"/>
                                            <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1339 431)" fill="#3490f3"/>
                                        </g>
                                    </svg>
                                </a>
                                <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $delivery->id) }}" title="{{ translate('Download Invoice') }}">
                                    <i class="las la-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="aiz-pagination mt-2">
                {{ $pickup_deliveries->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Cancel Request Modal -->
    @include('delivery_boys.cancel_request_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function confirm_cancel_request(url)
        {
            $('#cancel-request').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }
    
        function update_status(selectObject) {
            var order_id = selectObject.value;
            var status = "on_the_way";
            $.post('{{ route('delivery-boy.orders.update_delivery_status') }}', {
                _token      :'{{ @csrf_token() }}',
                order_id    :order_id,
                status      :status
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
                location.reload();
            });
        }
    </script>
@endsection
