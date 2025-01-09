@extends('delivery_boys.layouts.app')
@section('panel_content')

@php 
    $delivery_boy_info = get_delivery_boy_info();
@endphp

<div class="aiz-titlebar">
    <div class="row align-items-center">
        <div class="col-6">
            <h3 class="fs-20 fw-700 text-dark">{{ translate('Dashboard') }}</h3>
        </div>
        <div class="col-6 text-right">
            <p class="fs-14 fw-400 text-dark mb-0">{{ date('d M, Y') }}</p>
            <small class="fs-12 fw-400 text-secondary">{{ date('l') }}</small>
        </div>
    </div>
</div>

<div class="row gutters-16">

    <!-- Completed Delivery -->
    @php 
        $total_complete_delivery = get_delivery_boy_total_completed_delivery();
    @endphp
    <div class="col-md-6 py-3">
        <div class="d-flex align-items-center py-5 px-4 bg-dark border">
            <svg xmlns="http://www.w3.org/2000/svg" width="66.002" height="65.997" viewBox="0 0 66.002 65.997">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-651.998 -207.002)">
                  <path id="Subtraction_212" data-name="Subtraction 212" d="M16445-2274a32.784,32.784,0,0,1-12.844-2.594,32.9,32.9,0,0,1-10.49-7.073,32.909,32.909,0,0,1-7.074-10.49A32.781,32.781,0,0,1,16412-2307a32.778,32.778,0,0,1,2.594-12.844,32.894,32.894,0,0,1,7.074-10.488,32.9,32.9,0,0,1,10.49-7.071A32.792,32.792,0,0,1,16445-2340a32.792,32.792,0,0,1,12.844,2.593,32.9,32.9,0,0,1,10.49,7.071,32.86,32.86,0,0,1,7.072,10.488A32.778,32.778,0,0,1,16478-2307a32.781,32.781,0,0,1-2.594,12.845,32.878,32.878,0,0,1-7.072,10.49,32.9,32.9,0,0,1-10.49,7.073A32.784,32.784,0,0,1,16445-2274Zm0-64a30.8,30.8,0,0,0-12.066,2.436,30.935,30.935,0,0,0-9.855,6.643,30.928,30.928,0,0,0-6.643,9.854A30.8,30.8,0,0,0,16414-2307a30.8,30.8,0,0,0,2.436,12.067,30.923,30.923,0,0,0,6.643,9.855,30.931,30.931,0,0,0,9.855,6.645A30.8,30.8,0,0,0,16445-2276a30.8,30.8,0,0,0,12.066-2.437,30.9,30.9,0,0,0,9.854-6.645,30.917,30.917,0,0,0,6.643-9.855A30.8,30.8,0,0,0,16476-2307a30.8,30.8,0,0,0-2.436-12.066,30.916,30.916,0,0,0-6.643-9.854,30.9,30.9,0,0,0-9.854-6.643A30.812,30.812,0,0,0,16445-2338Z" transform="translate(-15760 2547)" fill="#58ba00" opacity="0.2"/>
                  <rect id="Rectangle_18646" data-name="Rectangle 18646" width="52" height="52" rx="26" transform="translate(659 214)" fill="#58ba00"/>
                  <g id="Group_25719" data-name="Group 25719" transform="translate(-65.256 -188.299) rotate(-45)">
                    <rect id="Rectangle_19508" data-name="Rectangle 19508" width="22" height="2" rx="1" transform="translate(218.501 835.55)" fill="#fff"/>
                    <rect id="Rectangle_19509" data-name="Rectangle 19509" width="2" height="12" rx="1" transform="translate(220.502 837.55) rotate(180)" fill="#fff"/>
                  </g>
                </g>
            </svg>
            <div class="text-white ml-3">
                <p class="mb-2 fs-14 fw-400">{{ translate('Completed Delivery') }}</p>
                <h4 class="mb-0 fs-24 fw-700">{{ sprintf('%02d', $total_complete_delivery) }}</h4>
            </div>
        </div>
    </div>

    <!-- Pending Delivery -->
    @php 
        $total_pending_delivery = get_delivery_boy_total_pending_delivery();
    @endphp
    <div class="col-md-6 py-3">
        <div class="d-flex align-items-center py-5 px-4 bg-dark border">
            <svg xmlns="http://www.w3.org/2000/svg" width="66.002" height="65.997" viewBox="0 0 66.002 65.997">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-1173.998 -207.002)">
                  <path id="Subtraction_213" data-name="Subtraction 213" d="M16445-2274a32.784,32.784,0,0,1-12.844-2.594,32.9,32.9,0,0,1-10.49-7.073,32.909,32.909,0,0,1-7.074-10.49A32.781,32.781,0,0,1,16412-2307a32.778,32.778,0,0,1,2.594-12.844,32.894,32.894,0,0,1,7.074-10.488,32.9,32.9,0,0,1,10.49-7.071A32.792,32.792,0,0,1,16445-2340a32.792,32.792,0,0,1,12.844,2.593,32.9,32.9,0,0,1,10.49,7.071,32.86,32.86,0,0,1,7.072,10.488A32.778,32.778,0,0,1,16478-2307a32.781,32.781,0,0,1-2.594,12.845,32.878,32.878,0,0,1-7.072,10.49,32.9,32.9,0,0,1-10.49,7.073A32.784,32.784,0,0,1,16445-2274Zm0-64a30.8,30.8,0,0,0-12.066,2.436,30.935,30.935,0,0,0-9.855,6.643,30.928,30.928,0,0,0-6.643,9.854A30.8,30.8,0,0,0,16414-2307a30.8,30.8,0,0,0,2.436,12.067,30.923,30.923,0,0,0,6.643,9.855,30.931,30.931,0,0,0,9.855,6.645A30.8,30.8,0,0,0,16445-2276a30.8,30.8,0,0,0,12.066-2.437,30.9,30.9,0,0,0,9.854-6.645,30.917,30.917,0,0,0,6.643-9.855A30.8,30.8,0,0,0,16476-2307a30.8,30.8,0,0,0-2.436-12.066,30.916,30.916,0,0,0-6.643-9.854,30.9,30.9,0,0,0-9.854-6.643A30.812,30.812,0,0,0,16445-2338Z" transform="translate(-15238 2547)" fill="#fc0011" opacity="0.2"/>
                  <rect id="Rectangle_19504" data-name="Rectangle 19504" width="52" height="52" rx="26" transform="translate(1181 214)" fill="#e71927"/>
                  <rect id="Rectangle_19508" data-name="Rectangle 19508" width="18" height="2" rx="1" transform="matrix(-0.839, -0.545, 0.545, -0.839, 1221.451, 250.464)" fill="#fff"/>
                  <rect id="Rectangle_19509" data-name="Rectangle 19509" width="2" height="15" rx="1" transform="translate(1206 226)" fill="#fff"/>
                  <rect id="Rectangle_19572" data-name="Rectangle 19572" width="6" height="6" rx="3" transform="translate(1204 237)" fill="#fff"/>
                </g>
            </svg>
            <div class="text-white ml-3">
                <p class="mb-2 fs-14 fw-400">{{ translate('Pending Delivery') }}</p>
                <h4 class="mb-0 fs-24 fw-700">{{ sprintf('%02d', $total_pending_delivery) }}</h4>
            </div>
        </div>
    </div>

    <!-- Total Collected -->
    <div class="col-md-6 py-3">
        <div class="d-flex align-items-center py-5 px-4 bg-dark border">
            <svg xmlns="http://www.w3.org/2000/svg" width="66.002" height="65.997" viewBox="0 0 66.002 65.997">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-651.998 -382.001)">
                  <path id="Subtraction_215" data-name="Subtraction 215" d="M16445-2274a32.784,32.784,0,0,1-12.844-2.594,32.9,32.9,0,0,1-10.49-7.073,32.909,32.909,0,0,1-7.074-10.49A32.781,32.781,0,0,1,16412-2307a32.778,32.778,0,0,1,2.594-12.844,32.894,32.894,0,0,1,7.074-10.488,32.9,32.9,0,0,1,10.49-7.071A32.792,32.792,0,0,1,16445-2340a32.792,32.792,0,0,1,12.844,2.593,32.9,32.9,0,0,1,10.49,7.071,32.86,32.86,0,0,1,7.072,10.488A32.778,32.778,0,0,1,16478-2307a32.781,32.781,0,0,1-2.594,12.845,32.878,32.878,0,0,1-7.072,10.49,32.9,32.9,0,0,1-10.49,7.073A32.784,32.784,0,0,1,16445-2274Zm0-64a30.8,30.8,0,0,0-12.066,2.436,30.935,30.935,0,0,0-9.855,6.643,30.928,30.928,0,0,0-6.643,9.854A30.8,30.8,0,0,0,16414-2307a30.8,30.8,0,0,0,2.436,12.067,30.923,30.923,0,0,0,6.643,9.855,30.931,30.931,0,0,0,9.855,6.645A30.8,30.8,0,0,0,16445-2276a30.8,30.8,0,0,0,12.066-2.437,30.9,30.9,0,0,0,9.854-6.645,30.917,30.917,0,0,0,6.643-9.855A30.8,30.8,0,0,0,16476-2307a30.8,30.8,0,0,0-2.436-12.066,30.916,30.916,0,0,0-6.643-9.854,30.9,30.9,0,0,0-9.854-6.643A30.812,30.812,0,0,0,16445-2338Z" transform="translate(-15760 2722)" fill="#ff4200" opacity="0.2"/>
                  <rect id="Rectangle_19502" data-name="Rectangle 19502" width="52" height="52" rx="26" transform="translate(659 389)" fill="#f50"/>
                  <g id="Group_25720" data-name="Group 25720" transform="translate(455 -277)">
                    <g id="Group_25710" data-name="Group 25710" transform="translate(218.898 683)">
                      <g id="Group_25709" data-name="Group 25709">
                        <path id="Union_29" data-name="Union 29" d="M10.478,7.233.375,1.4A.75.75,0,1,1,1.125.1L11.1,5.859,21.07.1a.75.75,0,1,1,.751,1.3l-10.1,5.833A.752.752,0,0,1,11.1,7.5h-.046A.75.75,0,0,1,10.478,7.233Z" transform="translate(0 10.5)" fill="#fff"/>
                        <path id="Union_30" data-name="Union 30" d="M10.478,7.233.375,1.4A.75.75,0,1,1,1.125.1L11.1,5.859,21.07.1a.75.75,0,1,1,.751,1.3l-10.1,5.833A.752.752,0,0,1,11.1,7.5h-.046A.75.75,0,0,1,10.478,7.233Z" transform="translate(0 6)" fill="#fff"/>
                        <path id="Union_31" data-name="Union 31" d="M21.07,7.4,11.1,1.642,1.125,7.4a.75.75,0,1,1-.75-1.3L10.479.268a.853.853,0,0,1,1.237,0L21.821,6.1a.75.75,0,0,1-.751,1.3Z" fill="#fff"/>
                      </g>
                    </g>
                    <rect id="Rectangle_19518" data-name="Rectangle 19518" width="24" height="24" transform="translate(218 680)" fill="none"/>
                  </g>
                </g>
            </svg>
            <div class="text-white ml-3">
                <p class="mb-2 fs-14 fw-400">{{ translate('Total Collected') }}</p>
                <h4 class="mb-0 fs-24 fw-700">{{ $delivery_boy_info->total_collection }}</h4>
            </div>
        </div>
    </div>

    <!-- Earnings -->
    <div class="col-md-6 py-3">
        <div class="d-flex align-items-center py-5 px-4 bg-dark border">
            <svg xmlns="http://www.w3.org/2000/svg" width="66.002" height="65.997" viewBox="0 0 66.002 65.997">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-1173.998 -382.001)">
                  <path id="Subtraction_214" data-name="Subtraction 214" d="M16445-2274a32.784,32.784,0,0,1-12.844-2.594,32.9,32.9,0,0,1-10.49-7.073,32.909,32.909,0,0,1-7.074-10.49A32.781,32.781,0,0,1,16412-2307a32.778,32.778,0,0,1,2.594-12.844,32.894,32.894,0,0,1,7.074-10.488,32.9,32.9,0,0,1,10.49-7.071A32.792,32.792,0,0,1,16445-2340a32.792,32.792,0,0,1,12.844,2.593,32.9,32.9,0,0,1,10.49,7.071,32.86,32.86,0,0,1,7.072,10.488A32.778,32.778,0,0,1,16478-2307a32.781,32.781,0,0,1-2.594,12.845,32.878,32.878,0,0,1-7.072,10.49,32.9,32.9,0,0,1-10.49,7.073A32.784,32.784,0,0,1,16445-2274Zm0-64a30.8,30.8,0,0,0-12.066,2.436,30.935,30.935,0,0,0-9.855,6.643,30.928,30.928,0,0,0-6.643,9.854A30.8,30.8,0,0,0,16414-2307a30.8,30.8,0,0,0,2.436,12.067,30.923,30.923,0,0,0,6.643,9.855,30.931,30.931,0,0,0,9.855,6.645A30.8,30.8,0,0,0,16445-2276a30.8,30.8,0,0,0,12.066-2.437,30.9,30.9,0,0,0,9.854-6.645,30.917,30.917,0,0,0,6.643-9.855A30.8,30.8,0,0,0,16476-2307a30.8,30.8,0,0,0-2.436-12.066,30.916,30.916,0,0,0-6.643-9.854,30.9,30.9,0,0,0-9.854-6.643A30.812,30.812,0,0,0,16445-2338Z" transform="translate(-15238 2722)" fill="#008ac3" opacity="0.2"/>
                  <rect id="Rectangle_19503" data-name="Rectangle 19503" width="52" height="52" rx="26" transform="translate(1181 389)" fill="#0088be"/>
                  <path id="Path_39415" data-name="Path 39415" d="M123.688,10.823v-2a1,1,0,0,0-2,0v2a4,4,0,0,0-4,4v1a4,4,0,0,0,4,4h2a2,2,0,0,1,2,2v1a2,2,0,0,1-2,2h-2a2,2,0,0,1-2-2,1,1,0,1,0-2,0,4,4,0,0,0,4,4v2a1,1,0,0,0,2,0v-2a4,4,0,0,0,4-4v-1a4,4,0,0,0-4-4h-2a2,2,0,0,1-2-2v-1a2,2,0,0,1,2-2h2a2,2,0,0,1,2,2,1,1,0,0,0,2,0,4,4,0,0,0-4-4" transform="translate(1084.312 396.177)" fill="#fff"/>
                </g>
            </svg>
            <div class="text-white ml-3">
                <p class="mb-2 fs-14 fw-400">{{ translate('Earnings') }}</p>
                @if(get_setting('delivery_boy_payment_type') == 'commission')
                    <h4 class="mb-0 fs-24 fw-700">
                        {{ $delivery_boy_info->total_earning }}/
                        <span>
                            <small>{{ translate('order') }}</small>
                        </span>
                    </h4>
                @endif
                @if(get_setting('delivery_boy_payment_type') == 'salary')
                    <h4 class="mb-0 fs-24 fw-700">
                        {{ get_setting('delivery_boy_salary') }} / {{ translate('mo') }}
                    </h4>
                @endif
            </div>
        </div>
    </div>
    
</div>

<div class="row gutters-16">

    <!-- Cancelled Delivery -->
    @php
        $cancelled_deliveries = get_delivery_boy_total_cancelled_delivery();
    @endphp
    <div class="col-lg-8 col-md-6 py-3">
        <div class="d-flex align-items-center p-4 bg-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14.929" height="14.929" viewBox="0 0 14.929 14.929">
                <g id="Group_25721" data-name="Group 25721" transform="translate(-226.708 -810)">
                  <rect id="Rectangle_18942" data-name="Rectangle 18942" width="20.112" height="1" rx="0.5" transform="translate(227.416 810) rotate(45)" fill="#fff"/>
                  <rect id="Rectangle_19510" data-name="Rectangle 19510" width="20.113" height="1" rx="0.5" transform="translate(241.638 810.707) rotate(135)" fill="#fff"/>
                </g>
            </svg>
            <p class="mb-0 fs-14 fw-700 text-white ml-3">{{ translate('Cancelled Delivery') }}</p>
            <h4 class="mb-0 fs-24 fw-700 text-white ml-3">
                {{ sprintf('%02d', $cancelled_deliveries) }}
            </h4>
        </div>
    </div>

    <!-- Request to Cancel -->
    <div class="col-lg-4 col-md-6 py-3">
        <div class="d-flex align-items-center p-4 bg-soft-primary border border-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16.355" height="16.355" viewBox="0 0 16.355 16.355">
                <g id="Group_25723" data-name="Group 25723" transform="translate(-1364 -569)">
                  <rect id="Rectangle_18942" data-name="Rectangle 18942" width="9.401" height="1" rx="0.5" transform="translate(1373.707 578) rotate(45)" fill="#d43533"/>
                  <path id="Subtraction_207" data-name="Subtraction 207" d="M7.52,13.162H2a2,2,0,0,1-2-2V2A2,2,0,0,1,2,0h9.162a2,2,0,0,1,2,2V7.521H12.2V2a1,1,0,0,0-1-1H2A1,1,0,0,0,1,2v9.2a1,1,0,0,0,1,1H7.52v.96Z" transform="translate(1364 569)" fill="#d43533"/>
                  <rect id="Rectangle_19541" data-name="Rectangle 19541" width="9.4" height="1" rx="0.5" transform="translate(1380.355 578.707) rotate(135)" fill="#d43533"/>
                  <rect id="Rectangle_19542" data-name="Rectangle 19542" width="1" height="5.641" rx="0.5" transform="translate(1370.08 569)" fill="#d43533"/>
                </g>
            </svg>
            <a href="{{ route('cancel-request-list') }}" class="fs-14 fw-400 text-primary hov-text-primary ml-3 d-flex align-items-center animate-underline-primary">
                <span class="text-primary mr-3">{{ translate('Request to Cancel') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="6.364" height="11.314" viewBox="0 0 6.364 11.314">
                    <g id="Group_25722" data-name="Group 25722" transform="translate(-1478.293 -554.343)">
                      <rect id="Rectangle_19574" data-name="Rectangle 19574" width="8" height="1" rx="0.5" transform="translate(1478.293 564.95) rotate(-45)" fill="#d43533"/>
                      <rect id="Rectangle_19575" data-name="Rectangle 19575" width="8" height="1" rx="0.5" transform="translate(1479 554.343) rotate(45)" fill="#d43533"/>
                    </g>
                </svg>
            </a>
        </div>
    </div>

</div>

<div class="row gutters-16 mb-4">

    <!-- On The Way Deliveries -->
    <div class="col-md-4 py-3">
        <a href="{{ route('on-the-way-deliveries') }}" class="d-flex flex-column align-items-center py-4 py-lg-5 border bg-light has-transition hov-bg-soft-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-751 -715)">
                  <rect id="Rectangle" width="70" height="70" rx="35" transform="translate(751 715)" fill="#d43533"/>
                  <g id="Group_25731" data-name="Group 25731" transform="translate(531.998 258.002)">
                    <g id="Group_25717" data-name="Group 25717" transform="translate(238 476)">
                      <g id="Group_25716" data-name="Group 25716" transform="translate(17.998)">
                        <path id="Subtraction_208" data-name="Subtraction 208" d="M2.005,11.9H2A7,7,0,1,1,14,7a6.959,6.959,0,0,1-2,4.9c-.062-.505-.593-.978-1.5-1.331A5,5,0,1,0,2,7a4.961,4.961,0,0,0,1.5,3.571c-.9.354-1.435.827-1.495,1.333Z" transform="translate(0)" fill="#fff"/>
                        <g id="Group_25715" data-name="Group 25715" transform="translate(1.346 9.86)">
                          <rect id="Rectangle_19547" data-name="Rectangle 19547" width="7.999" height="2" rx="1" transform="translate(4.242 5.656) rotate(-45)" fill="#fff"/>
                          <rect id="Rectangle_19548" data-name="Rectangle 19548" width="2" height="7.999" rx="1" transform="translate(0 1.414) rotate(-45)" fill="#fff"/>
                        </g>
                        <ellipse id="Ellipse_618" data-name="Ellipse 618" cx="2" cy="2" rx="2" ry="2" transform="translate(4.999 4.994)" fill="#fff"/>
                      </g>
                      <path id="Subtraction_211" data-name="Subtraction 211" d="M15,18H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H15a3,3,0,0,1,3,3V15A3,3,0,0,1,15,18ZM3,2A1,1,0,0,0,2,3V15a1,1,0,0,0,1,1H15a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1Z" transform="translate(0 13.998)" fill="#fff"/>
                      <path id="Rectangle_19552" data-name="Rectangle 19552" d="M0,0H2A0,0,0,0,1,2,0V5A1,1,0,0,1,1,6H1A1,1,0,0,1,0,5V0A0,0,0,0,1,0,0Z" transform="translate(7.999 15.998)" fill="#fff"/>
                      <path id="Rectangle_19559" data-name="Rectangle 19559" d="M0,0H2A0,0,0,0,1,2,0V5A1,1,0,0,1,1,6H1A1,1,0,0,1,0,5V0A0,0,0,0,1,0,0Z" transform="translate(19.998 29.996) rotate(-90)" fill="#fff"/>
                    </g>
                    <rect id="Rectangle_19556" data-name="Rectangle 19556" width="2" height="5.999" rx="1" transform="translate(262.997 494.205) rotate(45)" fill="#fff"/>
                    <rect id="Rectangle_19557" data-name="Rectangle 19557" width="5.999" height="2" rx="1" transform="translate(262.997 494.205) rotate(45)" fill="#fff"/>
                    <rect id="Rectangle_19558" data-name="Rectangle 19558" width="2" height="9.999" rx="1" transform="translate(261.997 495.998)" fill="#fff"/>
                  </g>
                </g>
            </svg>
            <span class="mb-0 mt-3 fs-14 fw-700 text-primary">{{ translate('On The Way Deliveries') }}</span>
        </a>
    </div>

    <!-- Picked Up Deliveries -->
    <div class="col-md-4 py-3">
        <a href="{{ route('pickup-deliveries') }}" class="d-flex flex-column align-items-center py-4 py-lg-5 border bg-light has-transition hov-bg-soft-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-1099 -715)">
                  <rect id="Rectangle" width="71" height="71" rx="35.5" transform="translate(1099 715)" fill="#f3af3d"/>
                  <g id="Group_25730" data-name="Group 25730" transform="translate(797 303)">
                    <rect id="Rectangle_19531" data-name="Rectangle 19531" width="19.998" height="2" rx="1" transform="translate(333.999 457.997)" fill="#fff"/>
                    <rect id="Rectangle_19533" data-name="Rectangle 19533" width="9.999" height="2" rx="1" transform="translate(322 432)" fill="#fff"/>
                    <rect id="Rectangle_19532" data-name="Rectangle 19532" width="2" height="23.997" rx="1" transform="translate(329.999 432)" fill="#fff"/>
                    <path id="Subtraction_202" data-name="Subtraction 202" d="M5,10a5,5,0,1,1,5-5A5.009,5.009,0,0,1,5,10ZM5,2A3,3,0,1,0,8,5,3,3,0,0,0,5,2Z" transform="translate(325.996 453.997)" fill="#fff"/>
                    <path id="Subtraction_204" data-name="Subtraction 204" d="M17,10H3A3,3,0,0,1,0,7V3A3,3,0,0,1,3,0H17a3,3,0,0,1,3,3V7A3,3,0,0,1,17,10ZM3,2A1,1,0,0,0,2,3V7A1,1,0,0,0,3,8H17a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1Z" transform="translate(333.995 445.999)" fill="#fff"/>
                    <path id="Subtraction_205" data-name="Subtraction 205" d="M11,10H3A3,3,0,0,1,0,7V3A3,3,0,0,1,3,0h8a3,3,0,0,1,3,3V7A3,3,0,0,1,11,10ZM3,2A1,1,0,0,0,2,3V7A1,1,0,0,0,3,8h8a1,1,0,0,0,1-1V3a1,1,0,0,0-1-1Z" transform="translate(333.987 438.003)" fill="#fff"/>
                  </g>
                </g>
            </svg>
            <span class="mb-0 mt-3 fs-14 fw-700 text-warning">{{ translate('Picked Up Deliveries') }}</span>
        </a>
    </div>

    <!-- Assigned Deliveries -->
    <div class="col-md-4 py-3">
        <a href="{{ route('assigned-deliveries') }}" class="d-flex flex-column align-items-center py-4 py-lg-5 border bg-light has-transition hov-bg-soft-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70">
                <g id="Group_25732" data-name="Group 25732" transform="translate(-1447 -715)">
                  <rect id="Rectangle" width="70" height="70" rx="35" transform="translate(1447 715)" fill="#0084b4"/>
                  <g id="Group_25729" data-name="Group 25729" transform="translate(1438.534 191.037)">
                    <path id="Path_2953" data-name="Path 2953" d="M20,5.963H12a3,3,0,0,0,0,6h8a3,3,0,0,0,0-6m0,4H12a1,1,0,0,1,0-2h8a1,1,0,0,1,0,2" transform="translate(27.466 537)" fill="#fff"/>
                    <path id="Path_2954" data-name="Path 2954" d="M25.982,9.963a1,1,0,0,1,0-2H27a5,5,0,0,1,5,5v20a5,5,0,0,1-5,5H5a5,5,0,0,1-5-5v-20a5,5,0,0,1,5-5H6.017a1,1,0,0,1,0,2H5a3,3,0,0,0-3,3v20a3,3,0,0,0,3,3H27a3,3,0,0,0,3-3v-20a3,3,0,0,0-3-3Z" transform="translate(27.466 537)" fill="#fff"/>
                    <g id="Group_25728" data-name="Group 25728" transform="translate(34.273 554.963)">
                      <rect id="Rectangle_19508" data-name="Rectangle 19508" width="16" height="2" rx="1" transform="translate(5.658 11.314) rotate(-45)" fill="#fff"/>
                      <rect id="Rectangle_19509" data-name="Rectangle 19509" width="2" height="10" rx="1" transform="translate(0 5.656) rotate(-45)" fill="#fff"/>
                    </g>
                  </g>
                </g>
            </svg>
            <span class="mb-0 mt-3 fs-14 fw-700" style="color: #0084b4;">{{ translate('Assigned Deliveries') }}</span>
        </a>
    </div>

</div>

@endsection
