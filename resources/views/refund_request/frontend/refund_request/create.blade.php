@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="card rounded-0 shadow-none border">
                        <div class="card-header border-bottom-0">
                            <h5 class="mb-0 fs-20 fw-700 text-dark">{{translate('Send Refund Request')}}</h5>
                        </div>
                        <div class="card-body">
                            <form class="" action="{{route('refund_request_send', $order_detail->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                                @csrf
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{translate('Product Name')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control mb-3 rounded-0" name="name" placeholder="{{translate('Product Name')}}" value="{{ $order_detail->product->getTranslation('name') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{translate('Amount')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control mb-3 rounded-0" name="amount" placeholder="{{translate('Product Price')}}" value="{{ $order_detail->price + $order_detail->tax }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{translate('Order Code')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control mb-3 rounded-0" name="code" value="{{ $order_detail->order->code }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{translate('Refund Reason')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="reason" rows="5" class="form-control mb-3 rounded-0" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 col-form-label fs-14">{{ translate('Image') }}</label>
                                            <div class="col-md-9">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                    <input type="hidden" name="images" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 text-right mt-3">
                                            <button type="submit" class="btn btn-primary rounded-0 w-150px">{{translate('Send Request')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
