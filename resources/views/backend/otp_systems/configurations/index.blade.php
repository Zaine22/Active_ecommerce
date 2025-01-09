@extends('backend.layouts.app')

@section('content')
    <div class="row">
        @foreach ($otp_configurations as $otp_configuration)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 h6">{{ ucfirst(translate($otp_configuration->type)) }}</h5>
                        </div>
                        
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" 
                                onchange='updateSettings(this, "{{ $otp_configuration->type }}")' 
                                @if($otp_configuration->value == 1) checked @endif
                                title="{{ translate('Activation') }}">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                            <input type="hidden" name="otp_method" value="{{ $otp_configuration->type }}">
                            @csrf
                            @include('backend.otp_systems.configurations.partials.'.$otp_configuration->type)
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
@endsection

@section('script')
    <script type="text/javascript">

        function updateSettings(el, type){
            if($(el).is(':checked')){
                var value = 1;
            }
            else{
                var value = 0;
            }
            $.post('{{ route('otp_configurations.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        $("#ZENDER_MODE").change(function() {
            var value = $(this).val();
            let changeVal = '';
            if (value == "devices") {
                changeVal = 'device';
            } else {
                changeVal = 'gateway';
            }
            $("#ZENDER_MODE_TYPE").val(changeVal).change();

        });
    </script>
@endsection
