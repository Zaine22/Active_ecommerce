@extends('delivery_boys.layouts.app')

@section('panel_content')
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Total Collection History') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead class="text-gray fs-12">
                    <tr>
                        <th class="pl-0">{{ translate('Code')}}</th>
                        <th data-breakpoints="lg">{{ translate('Date')}}</th>
                        <th>{{ translate('Amount')}}</th>
                        <th class="text-right pr-0">{{ translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody class="fs-14">
                    @foreach ($today_collections as $key => $collection)
                        <tr>
                            <!-- code -->
                            <td class="pl-0" style="vertical-align: middle;">
                                <a href="{{route('delivery-boy.order-detail', encrypt($collection->order->id))}}">{{ $collection->order->code }}</a>
                            </td>
                            <!-- Date -->
                            <td class="text-secondary" style="vertical-align: middle;">
                                {{ date('d-m-Y h:i A', strtotime($collection->created_at)) }}
                            </td>
                            <!-- Amount -->
                            <td class="fw-700" style="vertical-align: middle;">
                                {{ single_price($collection->collection) }}
                            </td>
                            <!-- Options -->
                            <td class="text-right pr-0" style="vertical-align: middle;">
                                <a href="{{route('delivery-boy.order-detail', encrypt($collection->order->id))}}" class="btn btn-soft-info btn-icon btn-circle btn-sm hov-svg-white" title="{{ translate('Order Details') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                        <g id="Group_24807" data-name="Group 24807" transform="translate(-1339 -422)">
                                            <rect id="Rectangle_18658" data-name="Rectangle 18658" width="12" height="1" transform="translate(1339 422)" fill="#3490f3"/>
                                            <rect id="Rectangle_18659" data-name="Rectangle 18659" width="12" height="1" transform="translate(1339 425)" fill="#3490f3"/>
                                            <rect id="Rectangle_18660" data-name="Rectangle 18660" width="12" height="1" transform="translate(1339 428)" fill="#3490f3"/>
                                            <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1339 431)" fill="#3490f3"/>
                                        </g>
                                    </svg>
                                </a>
                                <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $collection->order->id) }}" title="{{ translate('Download Invoice') }}">
                                    <i class="las la-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="aiz-pagination mt-2">
                {{ $today_collections->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection
