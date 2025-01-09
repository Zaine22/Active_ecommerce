@extends('frontend.layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="card rounded-0 shadow-none border">
                    <div class="card-header border-bottom-0">
                        <h5 class="mb-0 fs-20 fw-700 text-dark">{{ translate('Applied Refund Requests') }}</h5>
                    </div>
                    <div class="card-body py-0">
                        <table class="table aiz-table mb-0">
                            <thead class="text-gray fs-12">
                                <tr>
                                  <th class="pl-0">#</th>
                                  <th data-breakpoints="lg">{{ translate('Date') }}</th>
                                  <th>{{translate('Code')}}</th>
                                  <th data-breakpoints="lg">{{translate('Product')}}</th>
                                  <th data-breakpoints="lg">{{translate('Amount')}}</th>
                                  <th class="text-right pr-0 w-140px">{{translate('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody class="fs-14">
                                  @foreach ($refunds as $key => $refund)
                                      <tr>
                                          <td class="pl-0 text-dark" style="vertical-align: middle;">{{ sprintf('%02d', $key+1)  }}</td>
                                          <td class="text-secondary" style="vertical-align: middle;">{{ date('d-m-Y', strtotime($refund->created_at)) }}</td>
                                          <td style="vertical-align: middle;">
                                                @if ($refund->order != null)
                                                    <a href="{{route('purchase_history.details', encrypt($refund->order->id))}}" class="fw-700 text-primary">{{ $refund->order->code }}</a>
                                                @endif
                                          </td>
                                          <td style="vertical-align: middle;">
                                              @if ($refund->orderDetail != null && $refund->orderDetail->product != null)
                                                  {{ $refund->orderDetail->product->getTranslation('name') }}
                                              @endif
                                          </td>
                                          <td class="fw-700" style="vertical-align: middle;">
                                              @if ($refund->orderDetail != null)
                                                  {{single_price($refund->orderDetail->price)}}
                                              @endif
                                          </td>
                                          <td class="text-right pr-0" style="vertical-align: middle;">
                                              @if ($refund->refund_status == 1)
                                                  <span class="badge badge-inline badge-success p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('Approved')}}</span>
                                              @elseif ($refund->refund_status == 2)
                                                  <a href="javascript:void(0);" onclick="refund_reject_reason_show('{{ route('reject_reason_show', $refund->id )}}')" class="btn btn-soft-primary hov-svg-white btn-icon btn-circle btn-sm" title="{{ translate('Reject Reason') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.004" height="11.001" viewBox="0 0 12.004 11.001">
                                                        <g id="Group_24939" data-name="Group 24939" transform="translate(-1336.909 -418.5)">
                                                          <path id="Intersection_8" data-name="Intersection 8" d="M9246.738,757.5a5.908,5.908,0,0,0-9.655,0h-1.174a6.9,6.9,0,0,1,12,0Z" transform="translate(-7899 -335.501)" fill="#d43533"/>
                                                          <path id="Intersection_9" data-name="Intersection 9" d="M0,0H1.176A5.91,5.91,0,0,0,6,2.5,5.91,5.91,0,0,0,10.828,0H12A6.9,6.9,0,0,1,6,3.5,6.9,6.9,0,0,1,0,0Z" transform="translate(1336.909 426)" fill="#d43533"/>
                                                          <rect id="Rectangle_18880" data-name="Rectangle 18880" width="4" height="4" rx="2" transform="translate(1341 422)" fill="#d43533"/>
                                                        </g>
                                                    </svg>
                                                  </a>
                                                  <span class="badge badge-inline badge-danger p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('REJECTED')}}</span>
                                              @else
                                                  <span class="badge badge-inline badge-info p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{translate('PENDING')}}</span>
                                              @endif
                                          </td>
                                      </tr>
                                  @endforeach
                            </tbody>
                        </table>
                        {{ $refunds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal fade reject_reason_show_modal" id="modal-basic">
	<div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title h6">{{translate('Refund Request Reject Reason')}}</h5>
              <button type="button" class="close" data-dismiss="modal"></button>
          </div>
          <div class="modal-body reject_reason_show">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary rounded-0" data-dismiss="modal">{{translate('Close')}}</button>
          </div>
      </div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  function refund_reject_reason_show(url){
      $.get(url, function(data){
          $('.reject_reason_show').html(data);
          $('.reject_reason_show_modal').modal('show');
      });
  }
</script>
@endsection
