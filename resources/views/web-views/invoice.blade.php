<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{\App\CPU\translate('invoice')}}</title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">
    <style media="all">
        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: sans-serif;
            color: #333542;
        }

        /* IE 6 */
        * html .footer {
            position: absolute;
            top: expression((0-(footer.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #333542;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 0px solid{{$web_config['primary_color']}};;
        }

        .col-12 {
            width: 100%;
        }

        [class*='col-'] {
            float: left;
            /*border: 1px solid #F3F3F3;*/
        }

        .row:after {
            content: ' ';
            clear: both;
            display: block;
        }

        .wrapper {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .header-height {
            height: 15px;
            border: 1px{{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}};
        }

        .content-height {
            display: flex;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table.customers {
            background-color: #FFFFFF;
        }

        table.customers > tr {
            background-color: #FFFFFF;
        }

        table.customers tr > td {
            border-top: 5px solid #FFF;
            border-bottom: 5px solid #FFF;
        }

        .header {
            border: 1px solid #ecebeb;
        }

        .customers th {
            /*border: 1px solid #A1CEFF;*/
            padding: 8px;
        }

        .customers td {
            /*border: 1px solid #F3F3F3;*/
            padding: 14px;
        }

        .customers th {
            color: white;
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
        }

        .bg-primary {
            /*font-weight: bold !important;*/
            font-size: 0.95rem !important;
            text-align: left;
            color: white;
            {{--background-color:  {{$web_config['primary_color']}};--}}
              background-color: {{$web_config['primary_color']}};;
        }

        .bg-secondary {
            /*font-weight: bold !important;*/
            font-size: 0.95rem !important;
            text-align: left;
            color: #333542 !important;
            background-color: #E6E6E6;
        }

        .big-footer-height {
            height: 250px;
            display: block;
        }

        .table-total {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table-total th, td {
            text-align: left;
            padding: 10px;
        }

        .footer-height {
            height: 75px;
        }

        .for-th {
            color: white;
        {{--border: 1px solid  {{$web_config['primary_color']}};--}}


        }

        .for-th-font-bold {
            /*font-weight: bold !important;*/
            font-size: 0.95rem !important;
            text-align: left !important;
            color: #333542 !important;
            background-color: #E6E6E6;
        }

        .for-tb {
            margin: 10px;
        }

        .for-tb td {
            /*margin: 10px;*/
            border-style: hidden;
        }


        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {

        }

        .strong {
            font-size: 0.95rem;
        }

        .bold {
            font-weight: bold;
        }

        .for-footer {
            position: relative;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgb(214, 214, 214);
            height: auto;
            margin: auto;
            text-align: center;
        }

        .flex-start {
            display: flex;
            justify-content: flex-start;
        }

        .flex-end {
            display: flex;
            justify-content: flex-end;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }

        .inline {
            display: inline;
        }

        .content-position {
            padding: 15px 40px;
        }

        .content-position-y {
            padding: 0px 40px;
        }

        .triangle {
            width: 0;
            height: 0;
            border: 22px solid{{$web_config['primary_color']}};
            border-top-color: transparent;
            border-bottom-color: transparent;
            border-right-color: transparent;
        }

        .triangle2 {
            width: 0;
            height: 0;
            border: 22px solid white;
            border-top-color: white;
            border-bottom-color: white;
            border-right-color: white;
            border-left-color: transparent;
        }

        .h1 {
            font-size: 2em;
            margin-block-start: 0.67em;
            margin-block-end: 0.67em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .h2 {
            font-size: 1.5em;
            margin-block-start: 0.83em;
            margin-block-end: 0.83em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .h4 {
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .montserrat-normal-600 {
            font-family: Montserrat;
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 6px;
            /* or 150% */


            color: #363B45;
        }

        .montserrat-bold-700 {
            font-family: Montserrat;
            font-style: normal;
            font-weight: 700;
            font-size: 18px;
            line-height: 6px;
            /* or 150% */


            color: #363B45;
        }

        .text-white {
            color: white !important;
        }

        .bs-0 {
            border-spacing: 0;
        }
    </style>
</head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
@php
    use App\Model\BusinessSetting;
    $company_phone =BusinessSetting::where('type', 'company_phone')->first()->value;
    $company_email =BusinessSetting::where('type', 'company_email')->first()->value;
    $company_name =BusinessSetting::where('type', 'company_name')->first()->value;
    $company_web_logo =BusinessSetting::where('type', 'company_web_logo')->first()->value;
    $company_mobile_logo =BusinessSetting::where('type', 'company_mobile_logo')->first()->value;
@endphp

<div class="first" style="display: block; height:auto !important;background-color: #E6E6E6">
    <table class="content-position">
        <tr>
            <th style="text-align: left">
                <img height="70" width="200" src="{{asset("storage/app/public/company/$company_web_logo")}}"
                     alt="">
            </th>
            <th style="text-align: right">
                <h1 style="color: #030303; margin-bottom: 0px; font-size: 30px;text-transform: capitalize">{{\App\CPU\translate('invoice')}}</h1>
                @if($order['seller_is']!='admin' && $order['seller']->gst != null)
                    <h5 style="color: #030303; margin-bottom: 0px;text-transform: capitalize">{{\App\CPU\translate('GST')}}
                        : {{ $order['seller']->gst }}</h5>
                @endif
            </th>
        </tr>
    </table>

    <table class="bs-0">
        <tr>
            <th class="bg-primary content-position-y" style="padding-right: 0; height: 44px; text-align: left">
                <div>
                    <span class="h4 inline text-white text-uppercase">{{\App\CPU\translate('invoice')}} # </span>
                    <span class="inline">
                        <span class="h4 text-white" style="display: inline">{{ $order->id }}</span>
                    </span>
                </div>
            </th>
            <th class="bg-secondary content-position-y" style="text-align: right; height: 44px;">
                <span class="h4 inline"
                      style="color: #030303;padding-right: 15px;">{{\App\CPU\translate('date')}} : </span>
                <span class="inline h4">
                    <strong style="color: #030303; ">{{date('d-m-Y h:i:s a',strtotime($order['created_at']))}}</strong>
                </span>
            </th>
        </tr>
    </table>
</div>
{{--<hr>--}}
{{--<table>--}}
@if ($order->order_type == 'default_type')
<div class="row">
    <section>
        <table class="content-position-y" style="width: 100%">
            <tr>
                <td valign="top">
                    <span class="h2" style="margin: 0px;">{{\App\CPU\translate('shipping_to')}}: </span>
                    <div class="h4 montserrat-normal-600">
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer['email']}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->customer['phone']}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->shippingAddress ? $order->shippingAddress['address'] : ""}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->shippingAddress ? $order->shippingAddress['city'] : ""}} {{$order->shippingAddress ? $order->shippingAddress['zip'] : ""}}</p>
                        
                    </div>
                </td>
                <td valign="top">
                    <span class="h2" >{{\App\CPU\translate('billing_address')}}: </span>
                    <div class="h4 montserrat-normal-600">
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['contact_person_name'] : ""}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['phone'] : ""}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['address'] : ""}}</p>
                        <p style=" margin-top: 6px; margin-bottom:0px;">{{$order->billingAddress ? $order->billingAddress['city'] : ""}} {{$order->billingAddress ? $order->billingAddress['zip'] : ""}}</p>
                        
                    </div>
                </td>
            </tr>
        </table>
    </section>
</div>
@else
<div class="row">
    <section>
        <table class="content-position-y" style="width: 100%">
            <tr>
                <td valign="top">
                    <span class="h2" style="margin: 0px;">{{\App\CPU\translate('POS_order')}} </span>
                    
                </td>
                
            </tr>
        </table>
    </section>
</div>
@endif
{{--</table>--}}

<br>

<div class="row" style="margin: 20px 0; display:block; height:auto !important ;">
    <div class=" content-height content-position-y" style="">
        <table class="customers bs-0">
            <thead>
            <tr class="for-th">
                <th class="for-th bg-primary">{{\App\CPU\translate('no.')}}</th>
                <th class="for-th bg-primary">{{\App\CPU\translate('item_description')}}</th>
                <th class="for-th bg-secondary for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('unit_price')}}
                </th>
                <th class="for-th for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('qty')}}
                </th>
                <th class="for-th for-th-font-bold" style="color: black">
                    {{\App\CPU\translate('total')}}
                </th>
            </tr>
            </thead>
            @php
                $subtotal=0;
                $total=0;
                $sub_total=0;
                $total_tax=0;
                $total_shipping_cost=0;
                $total_discount_on_product=0;
                $extra_discount=0;
            @endphp
            <tbody>
            @foreach($order->details as $key=>$details)
                @php $subtotal=($details['price'])*$details->qty @endphp
                <tr class="for-tb" style=" border: 1px solid #D8D8D8;margin-top: 5px">
                    <td class="for-tb for-th-font-bold">{{$key+1}}</td>
                    <td class="for-tb">
                        {{$details['product']?$details['product']->name:''}}
                        <br>
                        {{\App\CPU\translate('variation')}} : {{$details['variant']}}
                    </td>
                    <td class="for-tb for-th-font-bold">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($details['price']))}}</td>
                    <td class="for-tb">{{$details->qty}}</td>
                    <td class="for-tb for-th-font-bold">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</td>
                </tr>

                @php
                    $sub_total+=$details['price']*$details['qty'];
                    $total_tax+=$details['tax'];
                    $total_shipping_cost+=$details->shipping ? $details->shipping->cost :0;
                    $total_discount_on_product+=$details['discount'];
                    $total+=$subtotal;
                @endphp
            @endforeach
            </tbody>

        </table>
    </div>
</div>
<?php
    if ($order['extra_discount_type'] == 'percent') {
        $extra_discount = ($sub_total / 100) * $order['extra_discount'];
    } else {
        $extra_discount = $order['extra_discount'];
    }
    
?>
@php($shipping=$order['shipping_cost'])
<div class="content-position-y" style=" display:block; height:auto !important;margin-top: 40px">
    <table>
        <tr>
            <th style="text-align: left; vertical-align: text-top;width:30%;">
                <h4 style="color: #130505 !important; margin:0px;">{{\App\CPU\translate('payment_details')}}</h4>
                <h5 style="color: #414141 !important ; padding-top:5px;">{{ str_replace('_',' ',$order->payment_method) }}</h5>
                <p style="color: #414141 !important ; padding-top:5px;">{{$order->payment_status}}
                    , {{date('y-m-d',strtotime($order['created_at']))}}</p>

                    @if ($order->delivery_type !=null)
                    <h4 style="color: #130505 !important; margin:0px;text-transform: capitalize;">{{\App\CPU\translate('delivery_info')}} </h4>
                    @if ($order->delivery_type == 'self_delivery')
                        <p style="color: #414141 !important ; padding-top:5px;">
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('self_delivery')}}
                            </span>
                            <br>
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('delivery_man_name')}} : {{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}
                            </span>
                            <br>
                            <span style="text-transform: capitalize">
                                {{\App\CPU\translate('delivery_man_phone')}} : {{$order->delivery_man['phone']}}
                            </span>
                        </p>
                    @else
                    <p style="color: #414141 !important ; padding-top:5px;">
                        <span>
                            {{$order->delivery_service_name}}
                        </span>
                        <br>
                        <span>
                            {{\App\CPU\translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                        </span>
                    </p>
                    @endif
                @endif
            </th>

            <th style="text-align: right;width:70%;">
                <table style="width: 96%;margin-left:41%; display: inline " class="text-right sm-padding strong bs-0">
                    <tbody>

                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('sub_total')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($sub_total))}}</td>

                    </tr>
                    <tr>
                        <th class="gry-color text-left text-uppercase"><b>{{\App\CPU\translate('tax')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total_tax))}}</td>
                    </tr>
                    @if($order->order_type == 'default_type')
                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('shipping')}}</b></th>
                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping))}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('coupon_discount')}}</b></th>
                        <td>
                            - {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->discount_amount))}}</td>
                    </tr>
                    <tr class="border-bottom">
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('discount_on_product')}}</b></th>
                        <td>
                            - {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total_discount_on_product))}}</td>
                    </tr>
                    @if ($order->order_type != 'default_type')
                    <tr class="border-bottom">
                        <th class="gry-color text-left"><b>{{\App\CPU\translate('extra_discount')}}</b></th>
                        <td>
                            - {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($extra_discount))}}</td>
                    </tr>
                    @endif
                    <tr class="bg-primary">
                        <th class="text-left"><b class="text-white">{{\App\CPU\translate('total')}}</b></th>
                        <td class="text-white">
                            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->order_amount))}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </th>
        </tr>
    </table>
</div>
<br>
<br><br><br>

<div class="row">
    <section>
        <table style="width: 100%">
            <tr>
                <th class="content-position-y bg-primary"
                    style="padding-top:10px; padding-bottom:10px;text-align: left; width: 50%">
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i
                            class="fa fa-phone text-white"></i> {{\App\CPU\translate('phone')}}
                        : {{\App\Model\BusinessSetting::where('type','company_phone')->first()->value}}</div>
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i
                            class="fa fa-globe text-white" aria-hidden="true"></i> {{\App\CPU\translate('website')}}
                        : {{url('/')}}</div>
                    <div class="text-white" style="padding-top:5px; padding-bottom:2px;"><i
                            class="fa fa-envelope text-white" aria-hidden="true"></i> {{\App\CPU\translate('email')}}
                        : {{$company_email}}</div>
                </th>
                <th class="bg-secondary content-position-y" style="text-align: right; ">

                </th>
            </tr>
        </table>
    </section>
</div>


</body>
</html>
