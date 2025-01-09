@extends('seller.layouts.app')

@section('panel_content')

	<div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="h3">{{ translate('Reason of Refund Request') }}</h3>
            </div>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">

                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Reason of Refund Request') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ $refund->reason }}

                                    @if($refund->images != null)
                                        <div class="spotlight-group d-flex flex-wrap mt-3">
                                            @foreach (explode(',', $refund->images) as $photo)
                                            <a href="{{ uploaded_asset($photo) }}" 
                                                class="mr-2 mr-md-3 mb-2 mb-md-3 border overflow-hidden has-transition hov-scale-img hov-border-primary"
                                                target="_blank">
                                                <img class="img-fit h-60px lazyload has-transition"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($photo) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
