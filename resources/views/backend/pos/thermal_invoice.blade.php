<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
	<style media="all">
        @page {
			margin: 0;
			padding:0;
		}
		body{
			font-size: 0.75rem;
			font-family: "<?php echo  $pdf_style_data['font_family'] ?>";
            font-weight: normal;
            direction: <?php echo  $pdf_style_data['direction'] ?>;
            text-align: <?php echo  $pdf_style_data['text_align'] ?>;
			padding:0;
			margin:0; 
		}
		.gry-color *,
		.gry-color{
			color:#000;
		}
		table{
			width: 100%;
		}
		table th{
			font-weight: normal;
		}
		table.padding th{
			padding: .25rem .7rem;
		}
		table.padding td{
			padding: .25rem .7rem;
		}
		table.sm-padding td{
			padding: .1rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #e8e8f5;
		}
		.text-left{
			text-align:<?php echo  $pdf_style_data['text_align'] ?>;
		}
		.text-right{
			text-align:<?php echo  $pdf_style_data['not_text_align'] ?>;
		}
		.line-separator {
			width: 100%; 
			text-align: center; 
			border-top: 1px dotted #9c9ca1; 
			margin: 10px 0 0; 
		} 
		.line-separator .line-separator-text { 
			background-color:#fff !important;
			margin-top: -6px;
			margin-left: auto;
			margin-right: auto;
			z-index: 1;
		}
	</style>
</head>
<body>
	<div>

		@php
			$logo = get_setting('header_logo');
		@endphp

		<div style="padding: 1rem;padding-bottom: 0">
			<div style="text-align: center;padding: 0.25rem;">
				@if($logo != null)
					<img src="{{ uploaded_asset($logo) }}" height="20">
				@else
					<img src="{{ static_asset('assets/img/logo.png') }}" height="20">
				@endif
			</div>
			<div style="text-align: center;">
				<span style="font-size: 1.5rem;">{{ get_setting('site_name') }}</span><br>
				<span>{{ get_setting('contact_address') }}</span><br>
				<span>{{  translate('Email') }}: {{ get_setting('contact_email') }}</span><br>
				<span>{{  translate('Phone') }}: {{ get_setting('contact_phone') }}</span><br>
			</div>
			<div class="line-separator"><div class="line-separator-text" style="width: 70px;">{{ translate('RETAIL INVOICE') }}</div></div>
			<table>
				<tr>
					<td>
						{{  translate('Order ID') }}: <span class="strong">{{ $order->code }}</span>
					</td>
					<td style="font-size: 1rem;" class="text-right strong">{{  translate('Date') }}: <span class="strong">{{ date('d M Y h:i:sa', $order->date) }}</span></td>
				</tr>
				<tr>
					<td>
						{{  translate('Payment method') }}: <span class="strong">{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</span>
					</td>
					<td style="font-size: 1rem;" class="text-right strong"></td>
				</tr>
			</table>
		</div>

		<div style="padding: 0 1rem;">
			<div style="border-bottom:1px dotted #9c9ca1;padding-bottom: 0.25rem;">
				<div class="line-separator"><div class="line-separator-text" style="width: 40px;">{{ translate('BILL TO') }}</div></div>
				<table>	
					@php
						$shipping_address = json_decode($order->shipping_address);
					@endphp
					<tr><td class="strong">{{ translate('Name') }}: {{ $shipping_address->name }}</small></td></tr>
					<tr><td class="gry-color small">{{ translate('Address') }}: {{ $shipping_address->address }}, {{ $shipping_address->city }},  @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif {{ $shipping_address->postal_code }}, {{ $shipping_address->country }}</small></td></tr>
					<tr><td class="gry-color small">{{ translate('Email') }}: {{ $shipping_address->email }}</small></td></tr>
					<tr><td class="gry-color small">{{ translate('Phone') }}: {{ $shipping_address->phone }}</small></td></tr>
				</table>
			</div>
		</div>

	    <div style="padding: 1rem;">
			<table class="text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="">
	                    <th width="35%" class="text-left" style="padding-left: 0">{{ translate('Product Name') }}</th>
	                    <th width="10%" class="text-left">{{ translate('Qty') }}</th>
	                    <th width="20%" class="text-left">{{ translate('Unit Price') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Tax') }}</th>
	                    <th width="20%" class="text-right" style="padding-right: 0">{{ translate('Total') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">
	                @foreach ($order->orderDetails as $key => $orderDetail)
		                @if ($orderDetail->product != null)
							<tr class="">
								<td style="padding-left: 0">
                                    {{ $orderDetail->product->name }} 
                                    @if($orderDetail->variation != null) ({{ $orderDetail->variation }}) @endif
                                    <br>
                                    
                                        @php
                                            $product_stock = json_decode($orderDetail->product->stocks->first(), true);
                                        @endphp
                                        {{translate('SKU')}}: {{ $product_stock['sku'] }}
                                    </small>
                                </td>
								<td class="">{{ $orderDetail->quantity }}</td>
								<td class="currency">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
								<td class="currency">{{ single_price($orderDetail->tax/$orderDetail->quantity) }}</td>
			                    <td class="text-right currency" style="padding-right: 0">{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
							</tr>
		                @endif
					@endforeach
	            </tbody>
			</table>
		</div>

	    <div style="padding:1rem;">
	        <table class="text-right sm-padding small strong">
				<tbody>
					<tr>
						<th class="gry-color text-left">{{ translate('Sub Total') }}</th>
						<td class="currency" style="padding-right: 0">{{ single_price($order->orderDetails->sum('price')) }}</td>
					</tr>
					<tr>
						<th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
						<td class="currency" style="padding-right: 0">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</td>
					</tr>
					<tr class="border-bottom">
						<th class="gry-color text-left">{{ translate('Total Tax') }}</th>
						<td class="currency" style="padding-right: 0">{{ single_price($order->orderDetails->sum('tax')) }}</td>
					</tr>
					<tr class="border-bottom">
						<th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
						<td class="currency" style="padding-right: 0">{{ single_price($order->coupon_discount) }}</td>
					</tr>
					<tr>
						<th class="text-left strong">{{ translate('Grand Total') }}</th>
						<td class="currency" style="padding-right: 0">{{ single_price($order->grand_total) }}</td>
					</tr>
				</tbody>
			</table>
	    </div>

	</div>
</body>
</html>
