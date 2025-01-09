@extends('seller.layouts.app')

@section('panel_content')

<h4 class="text-center text-muted">{{translate('POS Configuration')}}</h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Thermal Printer Size') }}</h5>
            </div>
            <div class="card-body text-center">
                <form class="form-horizontal" action="{{ route('pos_configuration.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="thermal_printer_width" placeholder="{{ translate('Print width in mm') }}" 
                            value="{{ auth()->user()->shop->thermal_printer_width }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">{{ translate('mm') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

