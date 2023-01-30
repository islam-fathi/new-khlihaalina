@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Order Details'))

@push('css_or_js')
    <style>
        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}            !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .card {
            border: none
        }


        .totals tr td {
            font-size: 13px
        }

        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: #FFFFFF;
            font-weight: 900;
            font-size: 13px;

        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 60px;

        }

        a {
            color: {{$web_config['primary_color']}};
            cursor: pointer;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }

        @media (max-width: 768px) {
            .for-tab-img {
                width: 100% !important;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 360px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }

            .order_table_tr {
                display: grid;
            }

            .order_table_td {
                border-bottom: 1px solid #fff !important;
            }

            .order_table_info_div {
                width: 100%;
                display: flex;
            }

            .order_table_info_div_1 {
                width: 50%;
            }

            .order_table_info_div_2 {
                width: 49%;
                text-align: {{Session::get('direction') === "rtl" ? 'left' : 'right'}}        !important;
            }

            .spandHeadO {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 16px;
            }

            .spanTr {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 16px;
                margin-top: 10px;
            }

            .amount {
                font-size: 13px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0px;

            }

        }
    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
            @include('web-views.partials._profile-aside')

            {{-- Content --}}
            <section class="col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <a class="page-link" href="{{ route('account-order') }}">
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\translate('back')}}
                        </a>
                    </div>
                </div>


                <div class="card box-shadow-sm">
                    @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                        <div class="card-header">
                            <h4>{{\App\CPU\translate('order_verification_code')}} : {{$order['verification_code']}}</h4>
                        </div>
                    @endif
                    <div class="payment mb-3  table-responsive">
                        @if(isset($order['seller_id']) != 0)
                            @php($shopName=\App\Model\Shop::where('seller_id', $order['seller_id'])->first())
                        @endif
                        <table class="table table-borderless">
                            <thead>
                            <tr class="order_table_tr" style="background: {{$web_config['primary_color']}}">
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span class="d-block spandHeadO">{{\App\CPU\translate('order_no')}}: </span>
                                        </div>
                                        <div class="order_table_info_div_2">
                                            <span class="spanTr"> {{$order->id}} </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('order_date')}}: </span>
                                        </div>
                                        <div class="order_table_info_div_2">
                                            <span
                                                class="spanTr"> {{date('d M, Y',strtotime($order->created_at))}} </span>
                                        </div>

                                    </div>
                                </td>
                                @if( $order->order_type == 'default_type')
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('shipping_address')}}: </span>
                                        </div>

                                        @if($order->shippingAddress)
                                            @php($shipping=$order->shippingAddress)
                                        @else
                                            @php($shipping=json_decode($order['shipping_address_data']))
                                        @endif

                                        <div class="order_table_info_div_2">
                                            <span class="spanTr">
                                                @if($shipping)
                                                    {{$shipping->address}},<br>
                                                     {{$shipping->city}}
                                                    , {{$shipping->zip}}
                                                    
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('billing_address')}}: </span>
                                        </div>

                                        @if($order->billingAddress)
                                            @php($billing=$order->billingAddress)
                                        @else
                                            @php($billing=json_decode($order['billing_address_data']))
                                        @endif

                                        <div class="order_table_info_div_2">
                                            <span class="spanTr">
                                                @if($billing)
                                                    {{$billing->address}}, <br>
                                                     {{$billing->city}}
                                                    , {{$billing->zip}}
                                                    
                                                @else
                                                    {{$shipping->address}},<br>
                                                     {{$shipping->city}}
                                                    , {{$shipping->zip}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            </thead>
                        </table>

                        <table class="table table-borderless">
                            <tbody>
                            @foreach ($order->details as $key=>$detail)
                                @php($product=json_decode($detail->product_details,true))
                                <tr>
                                    <div class="row">
                                        <div class="col-md-6"
                                             onclick="location.href='{{route('product',$product['slug'])}}'">
                                            <td class="col-2 for-tab-img">
                                                <img class="d-block"
                                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                     src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                                     alt="VR Collection" width="60">
                                            </td>
                                            <td class="col-10 for-glaxy-name" style="vertical-align:middle;">
                                                
                                                
                                                <a href="{{route('product',[$product['slug']])}}">
                                                    {{isset($product['name']) ? Str::limit($product['name'],40) : ''}}
                                                </a> 
                                                @if($detail->refund_request == 1)
                                                    <small> ({{\App\CPU\translate('refund_pending')}}) </small> <br>
                                                @elseif($detail->refund_request == 2)
                                                    <small> ({{\App\CPU\translate('refund_approved')}}) </small> <br>
                                                @elseif($detail->refund_request == 3)
                                                    <small> ({{\App\CPU\translate('refund_rejected')}}) </small> <br>
                                                @elseif($detail->refund_request == 4)
                                                    <small> ({{\App\CPU\translate('refund_refunded')}}) </small> <br>
                                                @endif<br>
                                                <span>{{\App\CPU\translate('variant')}} : </span>
                                                {{$detail->variant}}
                                            </td>
                                        </div>
                                        <div class="col-md-4">
                                            <td width="100%">
                                                <div
                                                    class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                                    <span
                                                        class="font-weight-bold amount">{{\App\CPU\Helpers::currency_converter($detail->price)}} </span>
                                                    <br>
                                                    <span>{{\App\CPU\translate('qty')}}: {{$detail->qty}}</span>

                                                </div>
                                            </td>
                                        </div>
                                        <?php
                                            $refund_day_limit=\App\CPU\Helpers::get_business_settings('refund_day_limit');
                                            $order_details_date = $detail->created_at;
                                            $current = \Carbon\Carbon::now();
                                            $length = $order_details_date->diffInDays($current);                                          

                                        ?>
                                        <div class="col-md-2">
                                            <td>
                                                @if($order->order_type == 'default_type')
                                                    @if($order->order_status=='delivered')
                                                        <a href="{{route('submit-review',[$detail->id])}}" class="btn btn-primary btn-sm d-inline-block w-100 mb-2">{{\App\CPU\translate('review')}}</a>
                                                        
                                                        @if($detail->refund_request !=0)
                                                            <a href="{{route('refund-details',[$detail->id])}}" class="btn btn-primary btn-sm d-inline-block w-100 mb-2">
                                                                {{\App\CPU\translate('refund_details')}}
                                                            </a>
                                                        @endif
                                                        @if( $length <= $refund_day_limit && $detail->refund_request == 0)
                                                            <a href="{{route('refund-request',[$detail->id])}}"
                                                            class="btn btn-primary btn-sm d-inline-block">{{\App\CPU\translate('refund_request')}}</a>
                                                        @endif
                                                    {{--@else
                                                        <a href="javascript:" onclick="review_message()"
                                                        class="btn btn-primary btn-sm d-inline-block w-100 mb-2">{{\App\CPU\translate('review')}}</a>
                                                        
                                                        @if($length <= $refund_day_limit)
                                                            <a href="javascript:" onclick="refund_message()"
                                                                class="btn btn-primary btn-sm d-inline-block">{{\App\CPU\translate('refund_request')}}</a>
                                                        @endif --}}
                                                    @endif
                                                @else
                                                    <label class="badge badge-secondary">
                                                            <a 
                                                            class="btn btn-primary btn-sm">{{\App\CPU\translate('pos_order')}}</a>
                                                        </label>
                                                @endif
                                            </td>    
                                        </div>
                                    </div>
                                    
                                </tr>
                            @endforeach
                            @php($summary=\App\CPU\OrderManager::order_summary($order))
                            </tbody>
                        </table>
                        @php($extra_discount=0)
                        <?php
                            if ($order['extra_discount_type'] == 'percent') {
                                $extra_discount = ($summary['subtotal'] / 100) * $order['extra_discount'];
                            } else {
                                $extra_discount = $order['extra_discount'];
                            }
                        ?>
                        @if($order->delivery_type !=null)
                        
                            <div class="p-2">
                        
                                <h4 style="color: #130505 !important; margin:0px;text-transform: capitalize;">{{\App\CPU\translate('delivery_info')}} </h4>
                                <hr>
                                <div class="m-2">
                                    @if ($order->delivery_type == 'self_delivery')
                                        <p style="color: #414141 !important ; padding-top:5px;">
                                    
                                            <span style="text-transform: capitalize">
                                                {{\App\CPU\translate('delivery_man_name')}} : {{$order->delivery_man['f_name'].' '.$order->delivery_man['l_name']}}
                                            </span>
                                            {{-- <br>
                                            <span style="text-transform: capitalize">
                                                {{\App\CPU\translate('delivery_man_phone')}} : {{$order->delivery_man['phone']}}
                                            </span> --}}
                                        </p>
                                    @else
                                    <p style="color: #414141 !important ; padding-top:5px;">
                                        <span>
                                            {{\App\CPU\translate('delivery_service_name')}} : {{$order->delivery_service_name}}
                                        </span>
                                        <br>
                                        <span>
                                            {{\App\CPU\translate('tracking_id')}} : {{$order->third_party_delivery_tracking_id}}
                                        </span>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($order->order_note !=null)
                            <div class="p-2">
                        
                                <h4>{{\App\CPU\translate('order_note')}}</h4>
                                <hr>
                                <div class="m-2">
                                    <p>
                                        {{$order->order_note}} 
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                {{--Calculation--}}
                <div class="row d-flex justify-content-end">
                    <div class="col-md-8 col-lg-5">
                        <table class="table table-borderless">
                            <tbody class="totals">
                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Item')}}</span></div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{$order->details->count()}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Subtotal')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['subtotal'])}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('text_fee')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['total_tax'])}}</span>
                                    </div>
                                </td>
                            </tr>
                            @if($order->order_type == 'default_type')
                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Shipping')}} {{\App\CPU\translate('Fee')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Discount')}} {{\App\CPU\translate('on_product')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($summary['total_discount_on_product'])}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Coupon')}} {{\App\CPU\translate('Discount')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($order->discount_amount)}}</span>
                                    </div>
                                </td>
                            </tr>

                            @if($order->order_type != 'default_type')
                                <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('extra')}} {{\App\CPU\translate('Discount')}}</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($extra_discount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            <tr class="border-top border-bottom">
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="font-weight-bold">{{\App\CPU\translate('Total')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                            class="font-weight-bold amount ">{{\App\CPU\Helpers::currency_converter($order->order_amount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content mt-4 for-mobile-glaxy ">
                    <a href="{{route('generate-invoice',[$order->id])}}" class="btn btn-primary for-glaxy-mobile"
                       style="width:49%;">
                        {{\App\CPU\translate('generate_invoice')}}
                    </a>
                    <a class="btn btn-secondary" type="button"
                       href="{{route('track-order.result',['order_id'=>$order['id']])}}"
                       style="width:50%; color: white">
                        {{\App\CPU\translate('Track')}} {{\App\CPU\translate('Order')}}
                    </a>

                </div>
            </section>
        </div>
    </div>

    

@endsection


@push('script')
    <script>
        function review_message() {
            toastr.info('{{\App\CPU\translate('you_can_review_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        function refund_message(){
            toastr.info('{{\App\CPU\translate('you_can_refund_request_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush

