@extends('delivery_boys.layouts.app')

@section('panel_content')
    <div class="aiz-titlebar mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="fs-20 fw-700 text-dark">{{ translate('Manage Profile') }}</h3>
        </div>
      </div>
    </div>

    <!-- Basic Info -->
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-16 fw-700 text-dark">{{ translate('Basic Info')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Your Name') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" placeholder="{{ translate('Your Name') }}" name="name" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <!-- Phone -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Your Phone') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" placeholder="{{ translate('Your Phone')}}" name="phone" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
                <!-- Photo -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <!-- Password -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Your Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control rounded-0" placeholder="{{ translate('New Password') }}" name="new_password">
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Confirm Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control rounded-0" placeholder="{{ translate('Confirm Password') }}" name="confirm_password">
                    </div>
                </div>
                <!-- Address -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ translate('Your Address') }}</label>
                    <div class="col-md-10">
                        <textarea class="form-control rounded-0 mb-3" placeholder="{{ translate('Your Address') }}" rows="3" name="address" required>{{ Auth::user()->address }}</textarea>
                    </div>
                </div>
                <!-- Update Profile Button -->
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary rounded-0 w-150px">{{translate('Update Profile')}}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Change -->
    <div class="card shadow-none rounded-0 border">
        <div class="card-header border-bottom-0">
            <h5 class="mb-0 fs-16 fw-700 text-dark">{{ translate('Change your email')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.change.email') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Your Email') }}</label>
                    </div>
                    <div class="col-md-10">
                        <!-- Email -->
                        <div class="input-group mb-3">
                          <input type="email" class="form-control rounded-0" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary new-email-verification rounded-0">
                                    <span class="d-none loading">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        {{ translate('Sending Email...') }}
                                    </span>
                                    <span class="default">{{ translate('Verify') }}</span>
                                </button>
                            </div>
                        </div>
                        <!-- Update Email Button -->
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary rounded-0 w-150px">{{translate('Update Email')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
        
            $('.new-email-verification').on('click', function() {
                $(this).find('.loading').removeClass('d-none');
                $(this).find('.default').addClass('d-none');
                var email = $("input[name=email]").val();
        
                $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
                    data = JSON.parse(data);
                    $('.default').removeClass('d-none');
                    $('.loading').addClass('d-none');
                    if(data.status == 2)
                        AIZ.plugins.notify('warning', data.message);
                    else if(data.status == 1)
                        AIZ.plugins.notify('success', data.message);
                    else
                        AIZ.plugins.notify('danger', data.message);
                });
            });
        })(jQuery);
    </script>
@endsection
