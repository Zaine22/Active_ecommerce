@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form class="" id="sort_requests" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-0 h6">{{ translate('Offline Wallet Recharge Requests') }}</h5>
                </div>

                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type"
                        onchange="sort_requests()">
                        <option value="" @if ($type == null) selected @endif>{{ translate('All') }}
                        </option>
                        <option value="1" @if ($type == 1) selected @endif id="wallet_request_status">
                            {{ translate('Approved') }}
                        </option>
                        <option value="0" @if ($type == 0) selected @endif id="wallet_request_status">
                            {{ translate('Pending') }}
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Method') }}</th>
                        <th>{{ translate('TXN ID') }}</th>
                        <th>{{ translate('Photo') }}</th>
                        <th>{{ translate('Approval') }}</th>
                        <th>{{ translate('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wallets as $key => $wallet)
                        @if ($wallet->user != null)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $wallet->user->name }}</td>
                                <td>{{ $wallet->amount }}</td>
                                <td>{{ $wallet->payment_method }}</td>
                                <td>{{ $wallet->payment_details }}</td>
                                <td>
                                    @if ($wallet->reciept != null)
                                        <a href="{{ uploaded_asset($wallet->reciept) }}"
                                            target="_blank">{{ translate('Open Reciept') }}</a>
                                    @endif
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input
                                            @can('approve_offline_wallet_recharge') onchange="update_approved(this)" @endcan
                                            value="{{ $wallet->id }}" type="checkbox"
                                            @if ($wallet->approval == 1) checked @endif
                                            @cannot('approve_offline_wallet_recharge') disabled @endcan
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{{ $wallet->created_at }}</td>
                        </tr>
                    @endif
                                            @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $wallets->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function update_approved(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('offline_recharge_request.approved') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Money has been added successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        // submit the form
        function sort_requests(el) {
            $('#sort_requests').submit();
        }
    </script>
@endsection
