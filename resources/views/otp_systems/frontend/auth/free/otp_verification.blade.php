@extends('auth.layouts.authentication')

@section('content')
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white overflow-hidden" style="min-height:100vh;">
            <div class="row" style="min-height: 100vh;">
                <!-- Left Side Image-->
                <div class="col-xxl-6 col-lg-7">
                    <div class="h-100">
                        <img src="{{ uploaded_asset(get_setting('phone_number_verify_page_image')) }}" alt="{{ translate('Phone Number Verify Page Image') }}" class="img-fit h-100">
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="col-xxl-6 col-lg-5">
                    <div class="right-content">
                        <div class="row align-items-center justify-content-center justify-content-lg-start h-100">
                            <div class="col-xxl-6 p-4 p-lg-5">
                                <!-- Site Icon -->
                                <div class="size-48px mb-3 mx-auto mx-lg-0">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="img-fit h-100">
                                </div>

                                <!-- Titles -->
                                <div class="text-center text-lg-left">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('OTP Verification')}}</h1>
                                    <h5 class="fs-14 fw-400 text-dark">
                                        {{ translate('Enter the verification code which we sent to your given phone number') }}( {{ $phone }})
                                    </h5>
                                </div>

                                <!-- OTP Verification form -->
                                <div class="pt-3">
                                    <div class="">
                                        <form class="form-default" role="form" action="{{ route('validate-otp-code') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="phone" value="{{ $phone }}">
                                            <div class="form-group">
                                                <label class="fs-14 fw-700 text-soft-dark">
                                                    {{  translate('Verification Code') }} 
                                                    <span class="text-primary fs-10">({{ translate('OTP expires 5 minutes after being sent.') }})</span>
                                                </label>
                                                <input type="number" class="form-control rounded-0" placeholder="{{  translate('Verification Code') }}" name="otp_code" autocomplete="off">
                                            </div>
                                            <div class="text-center mb-3">
                                                <a href="{{ route('resend-otp', $phone) }}" class="fs-14 fw-700 resendOtpLink" disabled style="pointer-events: none; color: #bdb7b7; ">
                                                    {{ translate('Resend OTP') }}
                                                </a>
                                                <span class="text-primary countdown fs-14 fw-700"></span>
                                            </div>
                                            <div class="mb-4 mt-4">
                                                <button type="submit" class="btn btn-primary btn-block fw-700 fs-14 rounded-0 submit-button">{{  translate('Verify') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var counter = '{{ $resendOtpTimeLeft }}';  // Countdown from 180 seconds
            var countdownElement = $('.countdown');
            var resendLink = $('.resendOtpLink');

            // Disable link initially
            resendLink.prop('disabled', true);

            // Countdown logic
            var countdownInterval = setInterval(function() {
                counter--;  // Decrease counter by 1 second

                // Update the countdown display
                countdownElement.text('('+counter+')');

                // Once counter reaches 0, enable the link and stop the countdown
                if (counter <= 0) {
                    clearInterval(countdownInterval);
                    resendLink.prop('disabled', false);  // Enable link
                    resendLink.css('pointer-events', 'auto');  // Enable clicking
                    resendLink.css('color', '#D42D2A');  // color Change
                    countdownElement.text('');  // Remove the counter display
                }
            }, 1000);  // Update every second
        });
    </script>
@endsection