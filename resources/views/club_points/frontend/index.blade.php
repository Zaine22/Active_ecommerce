@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="fs-20 fw-700 text-dark">{{ translate('My Clubpoints') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-dark overflow-hidden">
                        <div class="px-3 py-4">
                            <div class="fs-14 fw-400 text-center text-secondary mb-1">{{ translate('Exchange Rate') }}</div>
                            <div class="fs-30 fw-700 text-center text-white">{{ get_setting('club_point_convert_rate') }} {{ translate(' Points') }} = {{ single_price(1) }} {{ translate('Wallet Money') }}</div>
                        </div>
                    </div>
                    <br>

                    <div class="card rounded-0 shadow-none border">
                        <div class="card-header border-bottom-0">
                            <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Clubpoint Earning History')}}</h5>
                        </div>
                          <div class="card-body">
                              <table class="table aiz-table mb-0">
                                <thead class="text-gray fs-12">
                                    <tr>
                                        <th class="pl-0">#</th>
                                        <th>{{translate('Code')}}</th>
                                        <th data-breakpoints="lg">{{translate('Points')}}</th>
                                        <th data-breakpoints="lg">{{translate('Converted')}}</th>
                                        <th data-breakpoints="lg">{{translate('Date') }}</th>
                                        <th class="text-right pr-0">{{translate('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-14">
                                    @foreach ($club_points as $key => $club_point)
                                    @php 
                                        $convertible_club_point = $club_point->club_point_details->where('refunded',0)->sum('point'); 
                                    @endphp
                                        <tr>
                                            <td class="pl-0" style="vertical-align: middle;">{{ sprintf('%02d', $key+1) }}</td>
                                            <td class="fw-700 text-primary" style="vertical-align: middle;">
                                            @if ($club_point->order != null)
                                                    {{ $club_point->order->code }}
                                                @else
                                                    {{ translate('Order not found') }}
                                                @endif
                                            </td>
                                            <td class="fw-700" style="vertical-align: middle;">
                                                @if($convertible_club_point > 0)
                                                    {{ $convertible_club_point }} {{ translate(' pts') }}
                                                @else
                                                    {{ translate('Refunded') }}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle;">
                                                @if ($club_point->convert_status == 1)
                                                    <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px;">{{ translate('Yes') }}</strong></span>
                                                @else
                                                    <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px;">{{ translate('No') }}</strong></span>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle;">{{ date('d-m-Y', strtotime($club_point->created_at)) }}</td>

                                            <td class="text-right pr-0" style="vertical-align: middle;">

                                                @if ($club_point->convert_status == 0 && $convertible_club_point > 0)
                                                    <button onclick="convert_point({{ $club_point->id }})" class="btn btn-sm btn-styled btn-primary" style="border-radius: 25px;">{{translate('Convert Now')}}</button>
                                                @elseif($convertible_club_point == 0)
                                                    <span class="badge badge-inline text-white badge-warning p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{ translate('Refunded') }}</span>
                                                @else
                                                  <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{ translate('Done') }}</span>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <div class="aiz-pagination mt-3">
                                  {{ $club_points->links() }}
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function convert_point(el)
        {
            $.post('{{ route('convert_point_into_wallet') }}',{_token:'{{ csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    location.reload();
                    AIZ.plugins.notify('success', '{{ translate('Convert has been done successfully Check your Wallets') }}');
                }
                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
    		});
        }
    </script>
@endsection
