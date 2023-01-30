@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Order Details'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .sellerName {
            height: fit-content;
            margin-top: 10px;
            margin-left: 10px;
            font-size: 16px;
            border-radius: 25px;
            text-align: center;
            padding-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none p-3" style="background: white">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{route('admin.orders.list',['status'=>'all'])}}">{{\App\CPU\translate('Orders')}}</a>
                            </li>
                            <li class="breadcrumb-item active"
                                aria-current="page">{{\App\CPU\translate('Order')}} {{\App\CPU\translate('details')}} </li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">{{\App\CPU\translate('Order')}} #{{$order['id']}}</h1>

                        @if($order['payment_status']=='paid')
                            <span class="badge badge-soft-success ml-sm-3">
                                <span class="legend-indicator bg-success"></span>{{\App\CPU\translate('Paid')}}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-sm-3">
                                <span class="legend-indicator bg-danger"></span>{{\App\CPU\translate('Unpaid')}}
                            </span>
                        @endif

                        @if($order['order_status']=='pending')
                            <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-info text"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @elseif($order['order_status']=='failed')
                            <span class="badge badge-danger ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-info"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @elseif($order['order_status']=='processing' || $order['order_status']=='out_for_delivery')
                            <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-warning"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @elseif($order['order_status']=='delivered' || $order['order_status']=='confirmed')
                            <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-success"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @else
                            <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                              <span class="legend-indicator bg-danger"></span>{{str_replace('_',' ',$order['order_status'])}}
                            </span>
                        @endif
                        <span class="ml-2 ml-sm-3">
                        <i class="tio-date-range"></i> {{date('d M Y H:i:s',strtotime($order['created_at']))}}
                        </span>

                        @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                            <span class="ml-2 ml-sm-3">
                                <b>
                                    {{\App\CPU\translate('order_verification_code')}} : {{$order['verification_code']}}
                                </b>
                            </span>
                        @endif

                    </div>
                    <div class="col-md-6 mt-2">
                        <a class="text-body mr-3" target="_blank"
                           href={{route('admin.orders.generate-invoice',[$order['id']])}}>
                            <i class="tio-print mr-1"></i> {{\App\CPU\translate('Print')}} {{\App\CPU\translate('invoice')}}
                        </a>

                        @if (isset($shipping_address['latitude']) && isset($shipping_address['longitude']))
                            <button class="btn btn-xs btn-secondary" data-toggle="modal" data-target="#locationModal"><i
                                    class="tio-map"></i> {{\App\CPU\translate('show_locations_on_map')}}</button>
                        @else
                            <button class="btn btn-xs btn-warning"><i
                                    class="tio-map"></i> {{\App\CPU\translate('shipping_address_has_been_given_below')}}
                            </button>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mt-4">
                            <label class="badge badge-info">{{\App\CPU\translate('linked_orders')}}
                                : {{$linked_orders->count()}}</label><br>
                            @foreach($linked_orders as $linked)
                                <a href="{{route('admin.orders.details',[$linked['id']])}}"
                                   class="btn btn-secondary">{{\App\CPU\translate('ID')}}
                                    :{{$linked['id']}}</a>
                            @endforeach
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="hs-unfold float-right col-6">
                                <div class="dropdown">
                                    <select name="order_status" onchange="order_status(this.value)"
                                            class="status form-control"
                                            data-id="{{$order['id']}}">

                                        <option
                                            value="pending" {{$order->order_status == 'pending'?'selected':''}} > {{\App\CPU\translate('Pending')}}</option>
                                        <option
                                            value="confirmed" {{$order->order_status == 'confirmed'?'selected':''}} > {{\App\CPU\translate('Confirmed')}}</option>
                                        <option
                                            value="processing" {{$order->order_status == 'processing'?'selected':''}} >{{\App\CPU\translate('Processing')}} </option>
                                        <option class="text-capitalize"
                                                value="out_for_delivery" {{$order->order_status == 'out_for_delivery'?'selected':''}} >{{\App\CPU\translate('out_for_delivery')}} </option>
                                        <option
                                            value="delivered" {{$order->order_status == 'delivered'?'selected':''}} >{{\App\CPU\translate('Delivered')}} </option>
                                        <option
                                            value="returned" {{$order->order_status == 'returned'?'selected':''}} > {{\App\CPU\translate('Returned')}}</option>
                                        <option
                                            value="failed" {{$order->order_status == 'failed'?'selected':''}} >{{\App\CPU\translate('Failed')}} </option>
                                        <option
                                            value="canceled" {{$order->order_status == 'canceled'?'selected':''}} >{{\App\CPU\translate('Canceled')}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 hs-unfold float-right pr-2">
                                <div class="dropdown">
                                    <select name="payment_status" class="payment_status form-control"
                                            data-id="{{$order['id']}}">

                                        <option
                                            onclick="route_alert('{{route('admin.orders.payment-status',['id'=>$order['id'],'payment_status'=>'paid'])}}','Change status to paid ?')"
                                            href="javascript:"
                                            value="paid" {{$order->payment_status == 'paid'?'selected':''}} >
                                            {{\App\CPU\translate('Paid')}}
                                        </option>
                                        <option value="unpaid" {{$order->payment_status == 'unpaid'?'selected':''}} >
                                            {{\App\CPU\translate('Unpaid')}}
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
        </div>

        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header" style="display: block!important;">
                        <div class="row">
                            <div class="col-12 pb-2 border-bottom">
                                <h4 class="card-header-title">
                                    {{\App\CPU\translate('Order')}} {{\App\CPU\translate('details')}}
                                    <span
                                        class="badge badge-soft-dark rounded-circle ml-1">{{$order->details->count()}}</span>
                                </h4>
                            </div>

                            <div class="col-6 pt-2">
                                @if ($order->order_note !=null)
                                    <span class="font-weight-bold text-capitalize">
                                        {{\App\CPU\translate('order_note')}} :
                                    </span>
                                    <p class="pl-1">
                                        {{$order->order_note}}
                                    </p>
                                @endif
                            </div>
                            <div class="col-6 pt-2">
                                <div class="text-right">
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{\App\CPU\translate('Payment')}} {{\App\CPU\translate('Method')}}
                                        : {{str_replace('_',' ',$order['payment_method'])}}
                                    </h6>
                                    <h6 class="" style="color: #8a8a8a;">
                                        {{\App\CPU\translate('Payment')}} {{\App\CPU\translate('reference')}}
                                        : {{str_replace('_',' ',$order['transaction_ref'])}}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="media">
                            <div class="avatar avatar-xl mr-3">
                                <p>{{\App\CPU\translate('image')}}</p>
                            </div>

                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-4 product-name">
                                        <p> {{\App\CPU\translate('Name')}}</p>
                                    </div>

                                    <div class="col col-md-2 align-self-center p-0 ">
                                        <p> {{\App\CPU\translate('price')}}</p>
                                    </div>

                                    <div class="col col-md-1 align-self-center">
                                        <p>Q</p>
                                    </div>
                                    <div class="col col-md-1 align-self-center  p-0 product-name">
                                        <p> {{\App\CPU\translate('TAX')}}</p>
                                    </div>
                                    <div class="col col-md-2 align-self-center  p-0 product-name">
                                        <p> {{\App\CPU\translate('Discount')}}</p>
                                    </div>

                                    <div class="col col-md-2 align-self-center text-right  ">
                                        <p> {{\App\CPU\translate('Subtotal')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php($subtotal=0)
                        @php($total=0)
                        @php($shipping=0)
                        @php($discount=0)
                        @php($tax=0)
                        @foreach($order->details as $key=>$detail)

                            @if($detail->product)
                                @if ($key==0)
                                    @if($detail->product->added_by=='admin')
                                        <div class="row">
                                            <img
                                                class="avatar-img" style="width: 55px;height: 55px; border-radius: 50%;"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset('storage/app/public/company/'.\App\CPU\Helpers::get_business_settings('company_web_logo'))}}"
                                                alt="Image">
                                            <p class="sellerName">
                                                <a style="color: black;"
                                                   href="javascript:">
                                                    {{ \App\CPU\Helpers::get_business_settings('company_name')}}
                                                </a>
                                            </p>
                                        </div>
                                    @else

                                    @php($shop = \App\Model\Shop::where('seller_id','=',$detail->seller_id)->first())
                                        @if (isset($shop))
                                            <div class="row">
                                                <img
                                                    class="avatar-img" style="width: 55px;height: 55px; border-radius: 50%;"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/shop/'.$shop->image)}}"
                                                    alt="Image">
                                                <p class="sellerName">
                                                    <a style="color: black;"
                                                    href="{{route('admin.sellers.view',$detail->seller_id)}}">{{ $shop->name}}</a>
                                                    <i class="tio tio-info-outined ml-4" data-toggle="collapse"
                                                    style="font-size: 20px; cursor: pointer"
                                                    data-target="#sellerInfoCollapse-{{ $detail->id }}"
                                                    aria-expanded="false"></i>
                                                </p>
                                            </div>
                                        @endif

                                        @php($seller = App\Model\Seller::with('shop')->find($detail->seller_id))
                                        @if (isset($seller))
                                            <div class="collapse" id="sellerInfoCollapse-{{ $detail->id }}">
                                                <div class="row card-body mb-3">
                                                    <div class="col-6">
                                                        <h4>
                                                            {{\App\CPU\translate('Status')}}
                                                            : {!! $seller->status=='approved'?'<label class="badge badge-success">Active</label>':'<label class="badge badge-danger">In-Active</label>' !!}
                                                        </h4>
                                                        <h5>{{\App\CPU\translate('Email')}} : <a
                                                                class="text-dark"
                                                                href="mailto:{{ $seller->email }}">{{ $seller->email }}</a>
                                                        </h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>{{\App\CPU\translate('name')}} : <a
                                                                class="text-dark"
                                                                href="{{ route('admin.sellers.view', [$seller['id']]) }}">{{ $seller['shop']!=null?$seller['shop']->name:'' }}</a>
                                                        </h5>
                                                        <h5>{{\App\CPU\translate('Phone')}} : <a
                                                                class="text-dark"
                                                                href="tel:{{ $seller->phone }}">{{ $seller->phone }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            <!-- Media -->
                                <div class="media">
                                    <div class="avatar avatar-xl mr-3">
                                        <img class="img-fluid"
                                             onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                                             src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$detail->product['thumbnail']}}"
                                             alt="Image Description">
                                    </div>

                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3 mb-md-0 product-name">
                                                <p>
                                                    {{substr($detail->product['name'],0,30)}}{{strlen($detail->product['name'])>10?'...':''}}</p>
                                                <strong><u>{{\App\CPU\translate('Variation')}} : </u></strong>

                                                <div class="font-size-sm text-body">

                                                    <span class="font-weight-bold">{{$detail['variant']}}</span>
                                                </div>
                                            </div>

                                            <div class="col col-md-2 align-self-center p-0 ">
                                                <h6>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['price']))}}</h6>
                                            </div>

                                            <div class="col col-md-1 align-self-center">

                                                <h5>{{$detail->qty}}</h5>
                                            </div>
                                            <div class="col col-md-1 align-self-center  p-0 product-name">

                                                <h5>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['tax']))}}</h5>
                                            </div>
                                            <div class="col col-md-2 align-self-center  p-0 product-name">

                                                <h5>
                                                    {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($detail['discount']))}}</h5>
                                            </div>

                                            <div class="col col-md-2 align-self-center text-right  ">
                                                @php($subtotal=$detail['price']*$detail->qty+$detail['tax']-$detail['discount'])

                                                <h5 style="font-size: 12px">{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($subtotal))}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- seller info old --}}

                                @php($discount+=$detail['discount'])
                                @php($tax+=$detail['tax'])
                                @php($total+=$subtotal)
                            <!-- End Media -->
                                <hr>
                            @endif
                            @php($sellerId=$detail->seller_id)
                        @endforeach
                        @php($shipping=$order['shipping_cost'])
                        @php($coupon_discount=$order['discount_amount'])
                        {{-- <div>

                        </div> --}}
                        <div class="row justify-content-md-end mb-3">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-sm-right">
                                    <dt class="col-sm-6">{{\App\CPU\translate('Shipping')}}</dt>
                                    <dd class="col-sm-6 border-bottom">
                                        <strong>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($shipping))}}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{\App\CPU\translate('coupon_discount')}}</dt>
                                    <dd class="col-sm-6 border-bottom">
                                        <strong>- {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($coupon_discount))}}</strong>
                                    </dd>

                                    <dt class="col-sm-6">{{\App\CPU\translate('Total')}}</dt>
                                    <dd class="col-sm-6">
                                        <strong>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($total+$shipping-$coupon_discount))}}</strong>
                                    </dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <div class="card mb-2">
                    <div class="card-header">
                        <h4>{{\App\CPU\translate('shipping_info')}}</h4>
                    </div>
                    <div class="card-body text-capitalize">
                        <ul class="list-unstyled list-unstyled-py-2">
                            <li>
                                <h6 class="" style="color: #8a8a8a;">
                                    {{\App\CPU\translate('shipping_type')}}
                                    : {{str_replace('_',' ',$order->shipping_type)}}
                                </h6>
                            </li>
                            @if ($order->shipping_type == 'order_wise')
                            <li>
                                <h6 class="" style="color: #8a8a8a;">
                                    {{\App\CPU\translate('shipping')}} {{\App\CPU\translate('method')}}
                                    : {{$order->shipping ? $order->shipping->title :'No shipping method selected'}}
                                </h6>
                            </li>
                            @endif
                            <li>
                                <select class="form-control text-capitalize" name="delivery_type" onchange="choose_delivery_type(this.value)">
                                    <option value="0">
                                        {{\App\CPU\translate('choose_delivery_type')}}
                                    </option>
                                    
                                    <option value="self_delivery" {{$order->delivery_type=='self_delivery'?'selected':''}}>
                                        {{\App\CPU\translate('by_self_delivery_man')}}
                                    </option>
                                    <option value="third_party_delivery" {{$order->delivery_type=='third_party_delivery'?'selected':''}} >
                                        {{\App\CPU\translate('by_third_party_delivery_service')}}
                                    </option>
                                </select>
                            </li>
                            <li id="choose_delivery_man">
                                <label for="">
                                    {{\App\CPU\translate('choose_delivery_man')}}
                                </label>
                                <select class="form-control text-capitalize js-select2-custom" name="delivery_man_id" onchange="addDeliveryMan(this.value)">
                                    <option
                                        value="0">{{\App\CPU\translate('select')}}</option>
                                    @foreach($delivery_men as $deliveryMan)
                                        <option
                                            value="{{$deliveryMan['id']}}" {{$order['delivery_man_id']==$deliveryMan['id']?'selected':''}}>
                                            {{$deliveryMan['f_name'].' '.$deliveryMan['l_name'].' ('.$deliveryMan['phone'].' )'}}
                                        </option>
                                    @endforeach
                                </select>
                            </li>
                            <li class=" mt-2" id="by_third_party_delivery_service_info">
                                <span>
                                    {{\App\CPU\translate('delivery_service_name')}} : {{$order->delivery_service_name}}
                                </span>
                                <span style="float: right;">
                                    <a href="javascript:" onclick="choose_delivery_type('third_party_delivery')">
                                        <i class="tio-edit"></i>
                                    </a>
                                </span>
                                <br>
                                <span>
                                    {{\App\CPU\translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{\App\CPU\translate('Customer')}}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    @if($order->customer)
                        <div class="card-body">
                            <div class="media align-items-center" href="javascript:">
                                <div class="avatar avatar-circle mr-3">
                                    <img
                                        class="avatar-img" style="width: 75px;height: 42px"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/profile/'.$order->customer->image)}}"
                                        alt="Image">
                                </div>
                                <div class="media-body">
                                <span
                                    class="text-body text-hover-primary">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{--<i class="tio-chevron-right text-body"></i>--}}
                                </div>
                            </div>

                            <hr>

                            <div class="media align-items-center" href="javascript:">
                                <div class="icon icon-soft-info icon-circle mr-3">
                                    <i class="tio-shopping-basket-outlined"></i>
                                </div>
                                <div class="media-body">
                                    <span
                                        class="text-body text-hover-primary"> {{\App\Model\Order::where('customer_id',$order['customer_id'])->count()}} {{\App\CPU\translate('orders')}}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{--<i class="tio-chevron-right text-body"></i>--}}
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{\App\CPU\translate('Contact')}} {{\App\CPU\translate('info')}} </h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online mr-2"></i>
                                    {{$order->customer['email']}}
                                </li>
                                <li>
                                    <i class="tio-android-phone-vs mr-2"></i>
                                    {{$order->customer['phone']}}
                                </li>
                            </ul>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{\App\CPU\translate('shipping_address')}}</h5>
                            </div>

                            @if($order->shippingAddress)
                                @php($shipping_address=$order->shippingAddress)
                            @else
                                @php($shipping_address=json_decode($order['shipping_address_data']))
                            @endif

                            <span class="d-block">{{\App\CPU\translate('Name')}} :
                                <strong>{{$shipping_address? $shipping_address->contact_person_name : \App\CPU\translate('empty')}}</strong><br>
                                 
                                {{\App\CPU\translate('City')}}:
                                <strong>{{$shipping_address ? $shipping_address->city : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('zip_code')}} :
                                <strong>{{$shipping_address ? $shipping_address->zip  : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('address')}} :
                                <strong>{{$shipping_address ? $shipping_address->address  : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('Phone')}}:
                                <strong>{{$shipping_address ? $shipping_address->phone  : \App\CPU\translate('empty')}}</strong>
                            </span>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{\App\CPU\translate('billing_address')}}</h5>

                            </div>

                            @if($order->billingAddress)
                                @php($billing=$order->billingAddress)
                            @else
                                @php($billing=json_decode($order['billing_address_data']))
                            @endif

                            <span class="d-block">{{\App\CPU\translate('Name')}} :
                                <strong>{{$billing? $billing->contact_person_name : \App\CPU\translate('empty')}}</strong><br>
                                
                                {{\App\CPU\translate('City')}}:
                                <strong>{{$billing ? $billing->city : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('zip_code')}} :
                                <strong>{{$billing ? $billing->zip  : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('address')}} :
                                <strong>{{$billing ? $billing->address  : \App\CPU\translate('empty')}}</strong><br>
                                {{\App\CPU\translate('Phone')}}:
                                <strong>{{$billing ? $billing->phone  : \App\CPU\translate('empty')}}</strong>
                            </span>
                        </div>
                @else
                        <div class="card-body">
                            <div class="media align-items-center">
                                <span>{{\App\CPU\translate('no_customer_found')}}</span>
                            </div>
                        </div>
                @endif
                <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!--Show locations on map Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="locationModalLabel">{{\App\CPU\translate('location')}} {{\App\CPU\translate('data')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 modal_body_map">
                            <div class="location-map" id="location-map">
                                <div style="width: 100%; height: 400px;" id="location_map_canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show delivery info Modal -->
    <div class="modal" id="shipping_chose" role="dialog" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\translate('update_third_party_delivery_info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{route('admin.orders.update-deliver-info')}}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$order['id']}}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">{{\App\CPU\translate('delivery_service_name')}}</label>
                                        <input class="form-control" type="text" name="delivery_service_name" value="{{$order['delivery_service_name']}}" id="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{\App\CPU\translate('tracking_id')}} ({{\App\CPU\translate('optional')}})</label>
                                        <input class="form-control" type="text" name="third_party_delivery_tracking_id" value="{{$order['third_party_delivery_tracking_id']}}" id="">
                                    </div>
                                    <button class="btn btn-primary" type="submit">{{\App\CPU\translate('update')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                        
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endsection

@push('script_2')
    <script>
        $(document).on('change', '.payment_status', function () {
            var id = $(this).attr("data-id");
            var value = $(this).val();
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure Change this')}}?',
                text: "{{\App\CPU\translate('You will not be able to revert this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.payment-status')}}",
                        method: 'POST',
                        data: {
                            "id": id,
                            "payment_status": value
                        },
                        success: function (data) {
                            toastr.success('{{\App\CPU\translate('Status Change successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });

        function order_status(status) {
            @if($order['order_status']=='delivered')
            Swal.fire({
                title: '{{\App\CPU\translate('Order is already delivered, and transaction amount has been disbursed, changing status can be the reason of miscalculation')}}!',
                text: "{{\App\CPU\translate('Think before you proceed')}}.",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.status')}}",
                        method: 'POST',
                        data: {
                            "id": '{{$order['id']}}',
                            "order_status": status
                        },
                        success: function (data) {
                            if (data.success == 0) {
                                toastr.success('{{\App\CPU\translate('Order is already delivered, You can not change it')}} !!');
                                location.reload();
                            } else {
                                toastr.success('{{\App\CPU\translate('Status Change successfully')}}!');
                                location.reload();
                            }

                        }
                    });
                }
            })
            @else
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure Change this')}}?',
                text: "{{\App\CPU\translate('You will not be able to revert this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#377dff',
                cancelButtonColor: 'secondary',
                confirmButtonText: '{{\App\CPU\translate('Yes, Change it')}}!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.orders.status')}}",
                        method: 'POST',
                        data: {
                            "id": '{{$order['id']}}',
                            "order_status": status
                        },
                        success: function (data) {
                            if (data.success == 0) {
                                toastr.success('{{\App\CPU\translate('Order is already delivered, You can not change it')}} !!');
                                location.reload();
                            } else {
                                toastr.success('{{\App\CPU\translate('Status Change successfully')}}!');
                                location.reload();
                            }

                        }
                    });
                }
            })
            @endif
        }
    </script>
<script>
    $( document ).ready(function() {
        let delivery_type = '{{$order->delivery_type}}';

        
        if(delivery_type === 'self_delivery'){
            $('#choose_delivery_man').show();
            $('#by_third_party_delivery_service_info').hide();
        }else if(delivery_type === 'third_party_delivery')
        {
            $('#choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').show();
        }else{
            $('#choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').hide();
        }
    });
</script>
<script>
    function choose_delivery_type(val)
    {

        if(val==='self_delivery')
        {
            $('#choose_delivery_man').show();
            $('#by_third_party_delivery_service_info').hide();
        }else if(val==='third_party_delivery'){
            $('#choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').show();
            $('#shipping_chose').modal("show");
        }else{
            $('#choose_delivery_man').hide();
            $('#by_third_party_delivery_service_info').hide();
        }
        
    }
</script>
    <script>
        function addDeliveryMan(id) {
            $.ajax({
                type: "GET",
                url: '{{url('/')}}/admin/orders/add-delivery-man/{{$order['id']}}/' + id,
                data: {
                    'order_id': '{{$order['id']}}',
                    'delivery_man_id': id
                },
                success: function (data) {
                    if (data.status == true) {
                        toastr.success('Delivery man successfully assigned/changed', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    } else {
                        toastr.error('Deliveryman man can not assign/change in that status', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function () {
                    toastr.error('Add valid data', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        function last_location_view() {
            toastr.warning('Only available when order is out for delivery!', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function waiting_for_location() {
            toastr.warning('{{\App\CPU\translate('waiting_for_location')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&v=3.45.8"></script>
    <script>

        function initializegLocationMap() {
            var map = null;
            var myLatlng = new google.maps.LatLng({{$shipping_address->latitude}}, {{$shipping_address->longitude}});
            var dmbounds = new google.maps.LatLngBounds(null);
            var locationbounds = new google.maps.LatLngBounds(null);
            var dmMarkers = [];
            dmbounds.extend(myLatlng);
            locationbounds.extend(myLatlng);

            var myOptions = {
                center: myLatlng,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,

                panControl: true,
                mapTypeControl: false,
                panControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                scaleControl: false,
                streetViewControl: false,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                }
            };
            map = new google.maps.Map(document.getElementById("location_map_canvas"), myOptions);
            console.log(map);
            var infowindow = new google.maps.InfoWindow();

            @if($shipping_address && isset($shipping_address))
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({{$shipping_address->latitude}}, {{$shipping_address->longitude}}),
                map: map,
                title: "{{$order->customer['f_name']??""}} {{$order->customer['l_name']??""}}",
                icon: "{{asset('public/assets/front-end/img/customer_location.png')}}"
            });

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent("<div style='float:left'><img style='max-height:40px;wide:auto;' src='{{asset('storage/app/public/profile/')}}{{$order->customer->image??""}}'></div><div style='float:right; padding: 10px;'><b>{{$order->customer->f_name??""}} {{$order->customer->l_name??""}}</b><br/>{{$shipping_address->address??""}}</div>");
                    infowindow.open(map, marker);
                }
            })(marker));
            locationbounds.extend(marker.getPosition());
            @endif

            google.maps.event.addListenerOnce(map, 'idle', function () {
                map.fitBounds(locationbounds);
            });
        }

        // Re-init map before show modal
        $('#locationModal').on('shown.bs.modal', function (event) {
            initializegLocationMap();
        });
    </script>
@endpush
